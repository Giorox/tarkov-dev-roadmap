// aJax function and variables to dinamically pull a single event
function ajaxPullSingleEvent(id)
{
	return $.ajax({
		url:"assets/dist/pullSingleEvent.php", //the page containing php script
		type: "post", //request type,
		dataType: 'json',
		data: {id: id}
	});
}

// aJax function and variables to dinamically pull all events
function ajaxPullAllEvents()
{
	return $.ajax({
		url:"assets/dist/pullAllEvents.php", //the page containing php script
		type: "post", //request type,
		dataType: 'json'
	});
}

function drawLine()
{
	var destination = $(".starter-template").position();
	alert(destination.top);

	var $wipeDelimiter = $("<hr>", {"class": "single-line"});
	$wipeDelimiter.attr("style", "border: 1px solid red; position: absolute; top:" + destination.top + "px; width: 80%");
	$("main").append($wipeDelimiter);
}

// Function to set the current year on the copyright notice at the bottom of the page
function setCurrentYearInCopyright()
{
	var destination = $("#current-date");
	var currentYear = new Date().getFullYear();
	
	destination.text(currentYear);
}

// Function to build and show the desired micromodal
function createModal(id)
{
	$.when(ajaxPullSingleEvent(id)).done(function(a1)
	{
		var information = a1;
		$("#modal-extra-info-title").html("Update " + information["updateName"]);
		$("#modal-extra-info-expected-date").html("Expected Date: " + information["estimatedDate"]);
		$("#modal-extra-info-content").html("<p>" + information["extraInformation"] + "</p>");
		MicroModal.show('modal-extra-info');
	});
}

// Function to initialize the roadmap.JS script with some example events
function instantiateRoadmapVisualization()
{
	$.when(ajaxPullAllEvents()).done(function(a1)
	{
		var data = a1["data"];
		
		$("#tarkov-roadmap-timeline").roadmap(data, {
			eventsPerSlide: data.length,
			slide: 1,
			rootClass: 'roadmap',
			prevArrow: 'prev',
			nextArrow: 'next',
			orientation: 'vertical',
			eventTemplate: '<div class="event">' +
				'<a href="#">' +
				'<div class="event__date">####DATE###</div>' +
				'<div class="event__content off-white">####CONTENT###</div>' +
				'</a>' +
				'</div>'
		});
	});
}

// jQuery call functions once the document is ready
$( document ).ready(function() 
{
    setCurrentYearInCopyright();
	instantiateRoadmapVisualization();
});