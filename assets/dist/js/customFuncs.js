// Function to set the current year on the copyright notice at the bottom of the page
function setCurrentYearInCopyright()
{
	var destination = $("#current-date");
	var currentYear = new Date().getFullYear();
	
	destination.text(currentYear);
}

// jQuery call functions once the document is ready
$( document ).ready(function() 
{
    setCurrentYearInCopyright();
});