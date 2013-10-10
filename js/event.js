$(document).ready(function() {
	/****************
		  Event
	*****************/
	// Hide the event add new form
	$('#event_add_form_container').hide();
	
	// Resize images in event_slot if exceed 250x130
	$('.event_slot img').each(function() {
		$(this).load(function() {
			if (this.width > 250 || this.height > 130) {
				if (this.width > this.height)
					$(this).width(250);
				else
					$(this).height(130);
					
				var css = {
					position: 'relative',
					top: '50%',
					marginTop: '-' + (parseInt($(this).height()) / 2) + 'px',
					left: '50%',
					marginLeft: '-' + (parseInt($(this).width()) / 2) + 'px'
				};
				$(this).css(css);
			}
		});
	});
	
	// Also resize images, in the description
	$('#event_specific img').load(function() {
		if (this.width > 780 || this.height > 350) {
			if (this.width > this.height)
				$(this).width(780);
			else
				$(this).height(350);
		}
	});
	
	// Initialize variables for event
	var name;
	var content;
	var realcontent;
	
	// Add new crew
	$('#event_add_new').on('click', function() {
		$('#event_add_form_container').slideDown('slow');
	});
	
	$('#event_add_cancel').on('click', function() {
		$('#event_add_form_container').slideUp('slow');
	});
	
	// Function to change data to form (input text and text area)
	var input_text = function($target, $value, $placeholder) {
		$($target).html("<input type='text' id='input_name' name='name' value='"+$value+"' style='width:500px' placeholder='"+$placeholder+"'>");
	};
	
	var input_text_area = function($target, $value, $placeholder) {
		$($target).html("<textarea id='event_text_area' name='content' rows='7' cols='40' placeholder='"+$placeholder+"'>"+$value+"</textarea>");
	};
	
	// Hide event save edit button & cancel edit on default
	$('#event_save_edit, #event_edit_cancel').hide();
	
	// Edit crew
	$('#event_edit').on('click', function() {
		// Hide edit and delete buttons, show save button, change admin header
		$('#event_delete, #event_edit').fadeOut('slow');
		$('#event_save_edit, #event_edit_cancel').delay(800).fadeIn('slow');
		
		// Save the event details
		name = $('#event_header #name').html();
		realcontent = $('#event_content').html();
		content = $.trim(realcontent.replace(/\n/gi, "").replace(/<br\s*[\/]?>/gi, "\n"));
		
		// Change into form
		input_text('#event_header #name', name, "Event Name");
		input_text_area('#event_content', content, "Event Description");
	});
	
	// Save the edited crew
	$('#event_save_edit').on('click', function() {
		// Save the new details
		var iname = $('#input_name').val();
		var icontent = $('#event_text_area').val();
		var ID = $.trim($('#ID').html());
		
		// Show the ajax animation and hide the save button
		$(this).after("<img src='images/ajax2.gif' style='float:right;margin-top:17px;margin-right:14px'>");
		$(this).hide();
		
		// Do the ajax magic
		$.post("edit.php", {mode: "event", ID: ID, name: iname, content: icontent})
		.done(function(data) {
			if (data == "1") { // Success
				$('#name input').parent().html(iname);
				$('#event_content').html(icontent.replace(/\n/gi, "<br>"));
				
				$('#event_save_edit').next().remove();
				$(this).hide();
				$('#event_edit_cancel').hide();
				$('#event_delete, #event_edit').show();
				
				alert("Success on editing data !");
			} else { // Failed
				$('#name input').parent().html(name);
				$('#event_content').html(content.replace(/\n/gi, "<br>"));
				
				$('#event_save_edit').next().remove();
				$(this).hide();
				$('#event_edit_cancel').hide();
				$('#event_delete, #event_edit').show();
				
				alert("Failed on editing data !");
			}
		});
	});
	
	// Event handler for cancel editing
	$('#event_edit_cancel').on('click', function() {
		$('#event_header #name').html(name);
		$('#event_content').html(realcontent);
		
		$('#event_edit_cancel, #event_save_edit').fadeOut('slow');
		$('#event_delete, #event_edit').delay(800).fadeIn('slow');
	});
	
	// Delete crew
	$('#event_delete').on('click', function() {
		var c = confirm("Are you sure you want to delete this event ?");
		if (c == true) {
			var url = "delete.php";
			var ID = $.trim($('#ID').html());
			var gambar = $('#gambar').html();
			
			var form = $('<form action="'+url+'" method="POST" id="form_delete" style="display:none">' +
				'<input type="text" name="ID" value="'+ID+'">' +
				'<input type="text" name="gambar" value="'+gambar+'">' +
				'<input type="text" name="mode" value="event">' +
				'</form>'
			);
			
			$('body').append(form);
			$('#form_delete').submit();
		}
	});
	
	// Tidy last row in event slot
	var event_size = $('.event_slot').length;
	
	if (event_size % 3 == 1) {
		$('.event_slot:last-child').addClass('last_row_single');
	} else if (event_size % 3 == 2) {
		$('.event_slot:last-child').addClass('last_row_last').prev().addClass('last_row_first');
	}
});