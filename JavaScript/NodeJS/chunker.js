module.exports = function(){

		var eventEmitter = require('events').EventEmitter;
	 	
		function Chunker(){

		}

		Chunker.prototype = {

			regex: /\s+/gi,
			chunks: [],
			range: 5,

			events: new eventEmitter(),

			chunk: function(content, search){
				content = this.sanitize(content);
				
				var searchRegex = new RegExp('\\b' + search + '\\b', 'gi'),
					index = content.regexIndexOf(searchRegex),
					chunk = '',
					rangeStart = 0,
					rangeEnd = 0,
					counter = 0,
					current = 0;


				while(index > -1){

					current = content.regexLastIndexOf(this.regex, index);

					while(current > -1 && counter < this.range){

						current = current - 1;
						current = content.regexLastIndexOf(this.regex, current);
						if (current > -1){
							rangeStart = current;
						} else {
							rangeStart = 0;
						}

						counter++;

					}

					current = content.regexIndexOf(this.regex, index);
					counter = 0;

					while(current > -1 && counter < this.range){

						current = current + 1;
						current = content.regexIndexOf(this.regex, current);

						if (current > -1){
							rangeEnd = current;
						} else {
							rangeEnd = content.length;
						}

						counter++;

					}

					if(rangeStart > 0){
						rangeStart = rangeStart + 1;
					}

					this.chunks.push(content.substring(rangeStart, rangeEnd));
					current = 0;
					rangeStart = 0;
					rangeEnd = 0;
					counter = 0;
					index = content.indexOf(search, index + 1);
				}

				return this.chunks;
			},

			sanitize: function(content){
				content = content.replace(/(\r\n|\n|\r)/gm," ");
				content = content.replace(/\s+/g," ");
				return content;
			},
		}

		//From http://stackoverflow.com/questions/273789/is-there-a-version-of-javascripts-string-indexof-that-allows-for-regular-expr
		String.prototype.regexIndexOf = function(regex, startpos) {
		    var indexOf = this.substring(startpos || 0).search(regex);
		    var result = (indexOf >= 0) ? (indexOf + (startpos || 0)) : indexOf;
		    return result;
		}

		String.prototype.regexLastIndexOf = function(regex, startpos) {
		    regex = (regex.global) ? regex : new RegExp(regex.source, "g" + (regex.ignoreCase ? "i" : "") + (regex.multiLine ? "m" : ""));
		    if(typeof (startpos) == "undefined") {
		        startpos = this.length;
		    } else if(startpos < 0) {
		        startpos = 0;
		    }
		    var stringToWorkWith = this.substring(0, startpos + 1);
		    var lastIndexOf = -1;
		    var nextStop = 0;
		    while((result = regex.exec(stringToWorkWith)) != null) {
		        lastIndexOf = result.index;
		        regex.lastIndex = ++nextStop;
		    }

		    return lastIndexOf;
		}

		return new Chunker();
}
