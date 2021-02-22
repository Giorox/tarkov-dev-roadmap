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
		
		$(".sp-slides").empty();
		
		// Get all event images and add them as slides to slider-pro
		for (var i = 0; i < information["images"].length; i++)
		{
			var slideDiv = "<div class='sp-slide'><img class='sp-image' src='" + information["images"][i] + "'/></div>"; 
			$(".sp-slides").append(slideDiv);
		}
		
		// If there are no slides registered, add a special placeholder image
		if ($(".sp-slides").children().length == 0)
		{
			var placeholderImage = "<div class='sp-slide'><img class='sp-image' src='assets/img/no_registered_images.png'/></div>"; 
			$(".sp-slides").append(placeholderImage);
		}

		// Show modal
		MicroModal.show('modal-extra-info');

		// Instantiate slider-pro
		buildSliderPro();
	});
}

// Function to confirm if the user would like to logout
function confirmLogout()
{
	MicroModal.show('modal-confirm-logout');
}

// Function to enact the act of logging the administrator out
function logoutAdmin()
{
	window.location.href = "admin.php?action=logout";
}

// Function to confirm if the user would like to delete this update
function confirmDelete()
{
	MicroModal.show('modal-confirm-delete-update');
}

// Function to enact the act of deleting the update
function deleteUpdate()
{
	var updateID = $("#id_update").val();
	var url_location = "admin.php?action=deleteUpdate&id_update=" + updateID;
	window.location.href = url_location;
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
			eventTemplate: '<div class="event trkv-event-link">' +
				'<a class="nostyle" href="#">' +
				'<div class="event__date">####DATE###</div>' +
				'<div class="event__content off-white">####CONTENT###</div>' +
				'</a>' +
				'</div>'
		});
	});
}

// Function to show selected image file paths in editUpdate.php
function bindChangeEventToShowImageNames()
{
	$("input[id='updateImages']").change(function() {
		var names = [];
		for (var i = 0; i < $(this).get(0).files.length; ++i) {
			names.push($(this).get(0).files[i].name);
		}
		console.log(names);
		$("span[id='selected-images']").html(names.join(" -- "));
	});
}

// Function to initialize slider-pro
function buildSliderPro()
{
	$( '#extra-info-slider' ).sliderPro({
		width: 960,
		height: 500,
		fade: true,
		arrows: true,
		buttons: false,
		fullScreen: true,
		shuffle: false,
		smallSize: 500,
		mediumSize: 1000,
		largeSize: 3000,
		thumbnailArrows: true,
		autoplay: false
	});
}

// aJax function and variables to delete a single image
function ajaxDeleteSingleImage(imagePath, updateID)
{
	return $.ajax({
		url:"assets/dist/deleteImage.php", //the page containing php script
		type: "post", //request type,
		dataType: 'json',
		data: {
			imagePath: imagePath,
			updateID: updateID
		}
	});
}

// Function used to delete a single image from an update
function deleteImage(imagePath)
{
	var updateID = $("#id_update").val();

	$.when(ajaxDeleteSingleImage(imagePath, updateID)).done(function(a1)
	{
		if (a1 == 1)
		{
			location.reload();
		}
	});
}

// Function to call the modal asking the user to update his password
function callPasswordUpdateModal()
{
	MicroModal.show('modal-update-password');
}

// Actually do the password updating bit
function updatePassword(userID)
{
	// Get reference to the alert card
	var alertCard = $("#alert-card");
	
	// Get references to all 3 fields
	var oldPassword = $("#old_pass");
	var newPassword = $("#new_password");
	var newPasswordConfirmation = $("#confirm_new_password");
	
	// Remove is-invalid classes from all 3 fields
	newPassword.removeClass("is-invalid");
	newPasswordConfirmation.removeClass("is-invalid");
	oldPassword.removeClass("is-invalid");
	
	// Hide the alert card
	alertCard.removeClass("d-block");
	alertCard.addClass("d-none");

	
	// Check if newPassword and oldPassword are the same
	if (oldPassword.val() == newPassword.val())
	{
		// Set invalid classes where appropriate
		oldPassword.addClass("is-invalid");
		newPassword.addClass("is-invalid");
		
		// Edit the alert card text and write the new error message
		$("#errorMessage", alertCard).text("Old and new passwords cannot be the same.");
			
		// Remove the d-none class and add the d-block class to make the card appear
		alertCard.removeClass("d-none");
		alertCard.addClass("d-block");
		
		return false;
	}
	
	// Check if newPassword and newPasswordConfirmation are not the same
	if (newPassword.val() != newPasswordConfirmation.val())
	{
		// Set invalid classes where appropriate
		newPassword.addClass("is-invalid");
		newPasswordConfirmation.addClass("is-invalid");
		
		// Edit the alert card text and write the new error message
		$("#errorMessage", alertCard).text("New password and confirmation do not match.");
		
		// Remove the d-none class and add the d-block class to make the card appear
		alertCard.removeClass("d-none");
		alertCard.addClass("d-block");
		
		return false;
	}
	
	// Call ajax to check if the passwords match
	var passwordsMatch;
	
	$.ajax({
		url:"assets/dist/pullCurrentUserPassword.php", //the page containing php script
		type: "post", //request type,
		dataType: 'json',
		data: {
			id: userID,
			oldPassValue: oldPassword.val()
		},
		async: false,
		success: function(result){
			passwordsMatch = result;
		}
	});
	
	// If the passwords match, update the user password
	if(passwordsMatch)
	{
		var passwordChangeStatus;

		$.ajax({
			url:"assets/dist/changeUserPassword.php", //the page containing php script
			type: "post", //request type,
			dataType: 'json',
			data: {
				id: userID,
				newPassValue: newPassword.val()
			},
			async: false,
			success: function(result){
				passwordChangeStatus = result;
			}
		});
		
		// If the change was successful, remove the session object and close the modal
		if (passwordChangeStatus)
		{
			// Since JS session objects and PHP session objects are different, make an AJAX call to unset the desired SESSION variable
			unsetSessionVariable("needNewPass", true);
			MicroModal.close('modal-update-password');
		}
	}
	else
	{
		// Set invalid classes where appropriate
		oldPassword.addClass("is-invalid");
		
		// Edit the alert card text and write the new error message
		$("#errorMessage", alertCard).text("Incorrect current password.");
		
		// Remove the d-none class and add the d-block class to make the card appear
		alertCard.removeClass("d-none");
		alertCard.addClass("d-block");
		
		return false;
	}
}

// Ajax function to unsset 1 PHP SESSION variable
function unsetSessionVariable(variableName, runAsync = false)
{
	return $.ajax({
		url:"assets/dist/unsetSessionVariable.php", //the page containing php script
		type: "post", //request type,
		dataType: 'json',
		data: {
			variableName: variableName
		},
		async: runAsync
	});
}

// jQuery call functions once the document is ready
$( document ).ready(function() 
{
    setCurrentYearInCopyright();
	instantiateRoadmapVisualization();
	bindChangeEventToShowImageNames();
});