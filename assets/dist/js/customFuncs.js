// Function to set the current year on the copyright notice at the bottom of the page
function setCurrentYearInCopyright()
{
	var destination = $("#current-date");
	var currentYear = new Date().getFullYear();
	
	destination.text(currentYear);
}

// Function to initialize the roadmap.JS script with some example events
function instantiateRoadmapVisualization()
{
	var data = [
		{
			date: 'Next 2 months',
			content: 'Update .12.8'
		},
		{
			date: 'Q2 - 2018',
			content: 'Lorem ipsum dolor sit amet'
		},
		{
			date: 'Q3 - 2018',
			content: 'Lorem ipsum dolor sit amet'
		},
		{
			date: 'Q1 - 2019',
			content: 'Lorem ipsum dolor sit amet'
		},
		{
			date: 'Q2 - 2019',
			content: 'Lorem ipsum dolor sit amet'
		},
		{
			date: 'Q3 - 2019',
			content: 'Lorem ipsum dolor sit amet'
		},
		{
			date: 'Q4 - 2019',
			content: 'Lorem ipsum dolor sit amet'
		},
		{
			date: 'Q1 - 2020',
			content: 'Lorem ipsum dolor sit amet'
		}
	];
	
	$("#tarkov-roadmap-timeline").roadmap(data, {
		eventsPerSlide: data.length,
		slide: 1,
		rootClass: 'roadmap',
		prevArrow: 'prev',
		nextArrow: 'next',
		orientation: 'vertical',
		eventTemplate: '<div class="event">' +
			'<div class="event__date">####DATE###</div>' +
			'<div class="event__content off-white">####CONTENT###</div>' +
			'</div>'
	});
}

// jQuery call functions once the document is ready
$( document ).ready(function() 
{
    setCurrentYearInCopyright();
	instantiateRoadmapVisualization();
});