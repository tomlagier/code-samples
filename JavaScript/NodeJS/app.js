//The code below is NOT written by me. It comes from https://github.com/thedillonb/twitter-cashtag-heatmap. My code begins at line 179.

/**
 * Module dependencies.
 */
var express = require('express')
  , io = require('socket.io')
  , http = require('http')
  , twitter = require('ntwitter')
  , cronJob = require('cron').CronJob
  , _ = require('underscore')
  , path = require('path')
  , cheerio = require('cheerio')
  , events = require('events');

//Create an express app
var app = express();

//Create the HTTP server with the express app as an argument
var server = http.createServer(app);
var sockets = io.listen(server);

// IMPORTANT!!
//You will need to get your own key. Don't worry, it's free. But I cannot provide you one
//since it will instantiate a connection on my behalf and will drop all other streaming connections.
//Check out: https://dev.twitter.com/ You should be able to create an application and grab the following
//crednetials from the API Keys section of that application.
var api_key = 'hlnAZFXf3o1Z4HRnb1kcw';
var api_secret = 'kA1m91O5NXXt7NkPJhq84pzqxmhnfvNSidw5CBCc4uE';
var access_token = '2187433692-kpzd4STkkZPjO7QmZ3iRfAv97xk7kHpy4VVLjLc';
var access_token_secret = 'DqdlglNnY7uhm98iFjthH3QvHscGxH1nb4cin39XCM48b';

// Twitter symbols array.
var volumePage = '';
var watchSymbols = [];

getWatchSymbols();

//This structure will keep the total number of tweets received and a map of all the symbols and how many tweets received of that symbol
var watchList = {
    total: 0,
    geo: 0,
    symbols: {}
};

var appManager = new events.EventEmitter;

appManager.on('symbols-loaded', function(){


  //Set the watch symbols to zero.
  _.each(watchSymbols, function(v) { watchList.symbols[v].count = 0; });

  //Generic Express setup
  app.set('port', process.env.PORT || 3000);
  app.set('views', __dirname + '/views');
  app.set('view engine', 'jade');
  //app.use(express.logger('dev'));
  app.use(express.bodyParser());
  app.use(express.methodOverride());
  app.use(app.router);
  app.use(require('stylus').middleware(__dirname + '/public'));
  app.use(express.static(path.join(__dirname, 'public')));

  //We're using bower components so add it to the path to make things easier
  app.use('/components', express.static(path.join(__dirname, 'components')));

  // development only
  if ('development' == app.get('env')) {
    app.use(express.errorHandler());
  }

  //Our only route! Render it with the current watchList
  app.get('/', function(req, res) {
  	res.render('index', { data: watchList });
  });

  //Set the sockets.io configuration.
  //THIS IS NECESSARY ONLY FOR HEROKU!
  //sockets.configure(function() {
  //  sockets.set('transports', ['xhr-polling']);
  //  sockets.set('polling duration', 10);
  //});

  //If the client just connected, give them fresh data!
  sockets.sockets.on('connection', function(socket) { 
      socket.emit('data', watchList);
  });

  // Instantiate the twitter connection
  var t = new twitter({
      consumer_key: api_key,
      consumer_secret: api_secret,
      access_token_key: access_token,
      access_token_secret: access_token_secret
  });

  // //Tell the twitter API to filter on the watchSymbols 
  t.stream('statuses/filter', { track: watchSymbols }, function(stream) {

    //We have a connection. Now watch the 'data' event for incomming tweets.
    stream.on('data', function(tweet) {

      //This variable is used to indicate whether a symbol was actually mentioned.
      //Since twitter doesnt why the tweet was forwarded we have to search through the text
      //and determine which symbol it was ment for. Sometimes we can't tell, in which case we don't
      //want to increment the total counter...
      var claimed = false;

      console.log(tweet);

      //Make sure it was a valid tweet
      if (tweet.text !== undefined) {

        //We're gunna do some indexOf comparisons and we want it to be case agnostic.
        var text = tweet.text.toLowerCase();

        //Go through every symbol and see if it was mentioned. If so, increment its counter and
        //set the 'claimed' variable to true to indicate something was mentioned so we can increment
        //the 'total' counter!
        _.each(watchSymbols, function(v) {
            if (text.indexOf(v.toLowerCase()) !== -1) {
                watchList.symbols[v].count++;
                claimed = true;
            }
        });

        //If something was mentioned, increment the total counter and send the update to all the clients
        if (claimed) {
            //Increment total
            watchList.total++;

            if(tweet.geo || tweet.place || tweet.coordinates || tweet.user.location) {
              watchList.geo++;
            }

            //Send to all the clients
            sockets.sockets.emit('data', watchList);
        }
      }
    });
    });

  //Reset everything on a new day!
  //We don't want to keep data around from the previous day so reset everything.
  new cronJob('0 0 0 * * *', function(){

      //Reset the total
      watchList.total = 0;
      getWatchSymbols();

      save();

      //Send the update to the clients
      sockets.sockets.emit('data', watchList);
  }, null, true);

  //Create the server
  server.listen(app.get('port'), function(){
    console.log('Express server listening on port ' + app.get('port'));
  });

  //Update volumes every minute
  setInterval(function(){
    updateVolumes();
    console.log('Update volumes fired');
    sockets.sockets.emit('data', watchList);
  }, 60000);

});

//End repository code

//Begin Tom Lagier's code

function save()
{

}

function updateVolumes()
{

  volumePage = '';

  var options = {
    host: 'www.barchart.com',
    port: 80,
    path: '/stocks/vleaders.php?_dtp1=0'
  };

  http.get(options, function(res) {
    res.on('data', function(chunk){
      volumePage += chunk.toString(); 
    }).on('end', function(){
      setVolumes();     
    });
  }).on('error', function(e){
    console.log('Got error: ' + e.message);
  });

}

function setVolumes()
{
  $ = cheerio.load(volumePage);

  $('#dt1 > tbody > tr').each(function(index, row){
     var volume = $(row).find('.ds_volume').text();
     var symbol = '$' + $(row).find('.ds_symbol a').text().toLowerCase();

     if(typeof watchList.symbols[symbol] === 'undefined'){
      watchList.symbols[symbol] = new Symbol(row);
     }
     else{
      watchList.symbols[symbol].volume = volume;
     }

  });
}

function getWatchSymbols()
{
  var options = {
    host: 'www.barchart.com',
    port: 80,
    path: '/stocks/vleaders.php?_dtp1=0'
  };

  http.get(options, function(res) {
    res.on('data', function(chunk){
      volumePage += chunk.toString(); 
    }).on('end', function(){
      findWatchSymbols();
    });
  }).on('error', function(e){
    console.log('Got error: ' + e.message);
  });
}

function findWatchSymbols()
{
  $ = cheerio.load(volumePage);

  $('#dt1 > tbody > tr').each(function(index, row){
    var currentTicker = new Symbol(row);
    watchList.symbols['$' + currentTicker.ticker.toLowerCase()] = currentTicker;
    watchSymbols.push('$' + currentTicker.ticker.toLowerCase());
  });

  _.each(watchSymbols, function(v) { watchList.symbols[v].count = 0; });
  appManager.emit('symbols-loaded');
}

var Symbol = function(row)
{
  this.ticker = $(row).find('.ds_symbol a').text();
  this.price = $(row).find('.ds_last').text();
  this.change = $(row).find('.ds_change span').text();
  this.percentChange = $(row).find('.ds_pctchange span').text();
  this.high = $(row).find('.ds_high').text();
  this.low = $(row).find('.ds_low').text();
  this.volume = $(row).find('.ds_volume').text();
  this.count = 0;
}
