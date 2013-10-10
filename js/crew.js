$(document).ready(function() {
	/****************
		  Crew
	*****************/
	// Hide the crew description
	$('#crew_desc_bg').hide();
	$('#crew_desc_container').hide();
	$('.crew_desc').hide();
	$('#crew_add').hide();
	
	// Resize images in crew_slot if exceed 250x130
	$('.crew_slot img').each(function() {
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
	$('.crew_desc img').each(function() {
		$(this).load(function() {
			if (this.width > 750 || this.height > 350) {
				if (this.width > this.height)
					$(this).width(750);
				else
					$(this).height(350);
					
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
	
	// Initialize variables for crew
	var name;
	
	// Show the crew description from the corresponding image
	$('#crew_slot_container div').on('click', function() {
		var index = $('#crew_slot_container div').index(this);
		
		$('#crew_desc_bg').fadeIn('slow');
		$('#crew_desc_container').slideDown('slow');
		$('.crew_desc').eq(index).delay(600).fadeIn('slow');
		$('#normal_buttons').delay(600).fadeIn('slow');
	});
	
	// Add new crew
	$('#crew_add_new').on('click', function() {
		// Hide normal buttons, show save button, change admin header
		$('#normal_buttons').fadeOut('slow');
		$('#crew_save_add').fadeIn('slow');
		$('#crew_admin_header').html("Add New Data");
		$('#crew_admin_header').addClass("crew_add");
		
		// Show add crew form
		$('#crew_desc_bg').fadeIn('slow');
		$('#crew_desc_container').slideDown('slow');
		$('#crew_add').delay(600).fadeIn('slow');
	});
	
	// Function to change data to form (input text and text area)
	var input_text = function($parent, $child, $id, $value, $placeholder) {
		$parent.find($child).html("<input type='text' id='"+$id+"' value='"+$value+"' size='15' placeholder='"+$placeholder+"'>");
	};
	
	var input_text_area = function($parent, $child, $value, $placeholder) {
		$parent.find($child).html("<textarea id='program_text_area' rows='4' cols='30' placeholder='"+$placeholder+"'>"+$value+"</textarea>");
	};
	
	// Edit crew
	$('#crew_edit').on('click', function() {
		// Hide edit and delete buttons, show save button, change admin header
		$('#normal_buttons').fadeOut('slow');
		$('#crew_save_edit').delay(800).fadeIn('slow');
		$('#crew_admin_header').html("Edit Data");
		
		// Find the crew that is shown
		var crew_on = $('.crew_desc').filter(function() {
			var match = 'block';
			
			return ($(this).css('display') == match);
		});
		
		// Save the crew details
		name = crew_on.find('#crew_name #name').html();
		
		// Change into form
		input_text(crew_on, '#name', 'input_name', name, "Name");
	});
	
	// Save the edited crew
	$('#crew_save_edit').on('click', function() {
		// Save the new details
		var iname = $('#input_name').val();
		
		// Show the ajax animation and hide the save button
		$(this).after("<img src='images/ajax2.gif' style='float:right;margin-top:17px;margin-right:14px'>");
		$(this).hide();
		
		// Do the ajax magic
		$.post("edit.php", {mode: "crew", realname: name, name: iname})
		.done(function(data) {
			if (data == "1") { // Success
				$('#name input').parent().html(iname);
				
				$('#crew_save_edit').next().remove();
				$(this).hide();
				$('#normal_buttons').show();
				
				alert("Success on editing data !");
			} else { // Failed
				$('#name input').parent().html(name);
				
				$('#crew_save_edit').next().remove();
				$(this).hide();
				$('#normal_buttons').show();
				
				alert("Failed on editing data !");
			}
		});
	});
	
	// Delete crew
	$('#crew_delete').on('click', function() {
		var c = confirm("Are you sure you want to delete this crew ?");
		if (c == true) {
			var url = "delete.php";
			
			// Find the crew that is shown
			var crew_on = $('.crew_desc').filter(function() {
				var match = 'block';
				
				return ($(this).css('display') == match);
			});
			
			var dnama = crew_on.find('#name').html();
			var dID = crew_on.find('#ID').html();
			var dGambar = crew_on.find('#gambar').html();
			var form = $('<form action="'+url+'" method="POST" id="form_delete" style="display:none">' +
				'<input type="text" name="nama" value="'+dnama+'">' +
				'<input type="text" name="gambar" value="'+dGambar+'">' +
				'<input type="text" name="ID" value="'+dID+'">' +
				'<input type="text" name="mode" value="crew">' +
				'</form>'
			);
			
			$('body').append(form);
			$('#form_delete').submit();
		}
	});
	
	// Close the crew description
	$('#crew_close').on('click', function() {
		// Show edit and delete buttons, hide save button (if edit / add new button was clicked)
		$('#crew_admin_header').html("");
		$('#crew_admin_header').removeClass("crew_add");
		
		// Hide the details
		$('#crew_add').fadeOut('slow');
		$('.crew_desc').fadeOut('slow');
		$('#crew_desc_container').delay(600).slideUp('slow');
		$('#crew_desc_bg').delay(600).fadeOut('slow');
		$('#normal_buttons').fadeOut('slow');
		$('#crew_save_edit').fadeOut('slow');
		$('#crew_save_add').fadeOut('slow');
	});
	
	// Tidy last row in crew slot
	var crew_size = $('.crew_slot').length;
	
	if (crew_size % 3 == 1) {
		$('.crew_slot:last-child').addClass('last_row_single');
	} else if (crew_size % 3 == 2) {
		$('.crew_slot:last-child').addClass('last_row_last').prev().addClass('last_row_first');
	}
});