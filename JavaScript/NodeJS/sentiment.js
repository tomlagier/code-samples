var natural = require('natural'),
	eventEmitter = require('events').EventEmitter;

function SentimentAnalyzer(options)
{
	if(options && options.type){
		switch(options.type){
			case 'bayes':
				this.classifier = new natural.BayesClassifier();
				break;
			case 'logistic_regression':
				this.classifier = new natural.LogisticRegressionClassifier();
				break;
			default:
				console.log('Classifier not supported. Defaulting to Bayes');
				this.classifier = new natural.BayesClassifier();
		}
	} else {
		this.classifier = new natural.BayesClassifier();
	}

	if(options && options.content){
		this.content = options.content;
	}

	if(options && options.mappings){
		this.positive = options.mappings.positive;
		this.negative = options.mappings.negative;
		this.neutral = otions.mappings.neutral;
	}

	this.setDictionary((options && options.dictionary) ? options.dictionary : null);

}

SentimentAnalyzer.prototype = {
	
	setDictionary : function(options){
		var dictionary = require('./dictionary'),
			self = this;

		this.dictionary = dictionary.load(options ? options : null);

		this.dictionary.events.on('loaded', function(){
			self.train();
		});
	},

	terms : ['Seraph'],
	chunks : {},
	content : 'For those who did not see CLG\'s tweet and my CLG forum post about Seraph coming to the US and our expectations for his exposure, I felt it necessary to make a broader reaching statement regarding CLG\'s desired approach to introducing Seraph to the wonderful eSports community we have out in the West. We are all excited to have the Seraph out here, and I understand the community\'s desire to see him. Seraph is really excited to have come to the US, play for CLG, and a large aspect of that excitement is derived from the exposure he knows he can receive playing in the west. That being said, Seraph is quite young, and though he had a 6 month trail period with Najin in Korea, is still very new to the LoL scene. Culturally, he is the most removed player CLG has ever brought over, and Korean eSports operates very differently than eSports in the US. I believe we all want to see him succeed and most importantly, be happy in his new life. In order to do that, we feel that just throwing Seraph out onto the public stage, with everything that\'s going on for him right now might be too much to handle. He arrived in the US less than 24 hours ago. It\'s his first time in the states and the first time he\'s ever been removed completely from the ability to communicate with his native language. His english is good for a Korean, but he has a long ways to go. He hasn\'t even begun his tryout with CLG yet, let alone have we had time to educate him on expectations, not only from the organization, but our community and all his potential fans. We have seen repeatedly what community spotlight and pressures can do to a professional gamer\'s state of mind and quality of life. Nien JUST left CLG largely because of this. We need time to help Seraph adjust to his new surroundings and develop a proper support system for him before he\'s fully unleashed to the masses, and CLG is asking the community to respect our wishes on this. Don\'t worry, we already have unique, established plans around content for Seraph down the road. Slowly but surely, you will see more and more of him. I can already tell he\'s a really good kid, and I can\'t wait till everyone else can see it too. Thanks for your understanding.',

	positive: {
		label: 'good',
		values: [2, 3, 4, 5],
	},
	negative: {
		label: 'bad',
		values: [-2, -3, -4, -5],
	},
	neutral: {
		label: 'neutral',
		values: [-1, 0, 1],
	}, 

	events: new eventEmitter(),

	train : function(options){

		var self = this, label;

		self.dictionary.words.forEach(function(word){

			self.terms.forEach(function(term){

				if(self.positive.values.indexOf(parseInt(word.value)) > -1){
					label = self.positive.label;
				} else if (self.negative.values.indexOf(parseInt(word.value)) > -1){
					label = self.negative.label;
				} else if (self.neutral.values.indexOf(parseInt(word.value)) > -1){
					label = self.neutral.label;
				}

				self.classifier.addDocument(word.phrase, label);

			});

		});

		self.classifier.save('classifier.json', function(err, classifier){

		});

		self.classifier.train();

		self.events.emit('trained');
	},

	analyze : function(){

		this.chunk();

		var maxVal = 0, result = '', classifications, self = this;

		for(term in self.chunks){
		
			self.chunks[term].forEach(function(chunk, index){

				classifications = self.classifier.getClassifications(chunk);

				self.chunks[term][index] = {text: chunk, sentiment: self.classifier.classify(chunk)};

				maxVal = 0; result = '';

			});
		}

		console.log(self.chunks);

	},

	chunk : function(){
		var chunker = require('./chunker')();

		var self = this;

		this.terms.forEach(function(term){
			self.chunks[term] = chunker.chunk(self.content, term);
		});
	}
}

analyzer = new SentimentAnalyzer();

analyzer.events.on('trained', function(){
	analyzer.analyze();
});