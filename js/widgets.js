//resuable widgets in javascript classes to minimize repetition of code

var CalendarItem = function(a,b,c){

	this.Type = a ? a :"Variable";
	this.DateFrom = b ? b : new Date();
	this.DateTo = c ? c : new Date();
	this.DaysOfWeek = "M";
	this.Repeat = "None";
	
	this.render = function(){
		var html = '<div class="calendar-item-main">';
		html += '<span class="one">'+this.Type+ '</span>';
		html += '<span class="one">'+this.DateFrom+ '</span>';
		return html;
	}

}