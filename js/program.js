$(document).ready(function() {	
	/****************
		 Program
	*****************/
	// Hide the program description
	$('#program_desc_bg').hide();
	$('#program_desc_container').hide();
	$('.program_desc').hide();
	$('#program_add').hide();
	
	// Resize images in program_slot if exceed 250x130
	$('.program_slot img').each(function() {
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
	$('.program_desc img').each(function() {
		$(this).load(function() {
			if (this.width > 252 || this.height > 132) {
				if (this.width > this.height)
					$(this).width(252);
				else
					$(this).height(132);
					
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
	
	// Initialize variables for program
	var name;
	var host;
	var jadwal;
	var desc;
	
	// Show the program description from the corresponding image
	$('#program_slot_container div').on('click', function() {
		var index = $('#program_slot_container div').index(this);
		
		$('#program_desc_bg').fadeIn('slow');
		$('#program_desc_container').slideDown('slow');
		$('.program_desc').eq(index).delay(600).fadeIn('slow');
		$('#normal_buttons').delay(600).fadeIn('slow');
	});
	
	// Function to change data to form (input text and text area)
	var input_text = function($parent, $child, $id, $value, $placeholder) {
		$parent.find($child).html("<input type='text' id='"+$id+"' value='"+$value+"' size='15' placeholder='"+$placeholder+"'>");
	};
	
	var input_text_area = function($parent, $child, $value, $placeholder) {
		$parent.find($child).html("<textarea id='program_text_area' rows='4' cols='30' placeholder='"+$placeholder+"'>"+$value+"</textarea>");
	};
	
	// Add new program
	$('#program_add_new').on('click', function() {
		// Hide normal buttons, show save button, change admin header
		$('#normal_buttons').fadeOut('slow');
		$('#program_save_add').fadeIn('slow');
		$('#program_admin_header').html("Add New Program");
		$('#program_admin_header').addClass("program_add");
		
		// Show add program form
		$('#program_desc_bg').fadeIn('slow');
		$('#program_desc_container').slideDown('slow');
		$('#program_add').delay(600).fadeIn('slow');
	});
	
	// Edit program
	$('#program_edit').on('click', function() {
		// Hide edit and delete buttons, show save button, change admin header
		$('#normal_buttons').fadeOut('slow');
		$('#program_save_edit').delay(800).fadeIn('slow');
		$('#program_admin_header').html("Edit Program");
		
		// Find the program that is shown
		var program_on = $('.program_desc').filter(function() {
			var match = 'block';
			
			return ($(this).css('display') == match);
		});
		
		// Save the program details
		name = program_on.find('#name').html();
		host = program_on.find('#program_host #italic').html();
		jadwal = program_on.find('#jadwal').html();
		desc = program_on.find('#desc').html();
		
		// Change into form
		input_text(program_on, '#name', 'input_name', name, "Name");
		input_text(program_on, '#program_host', 'input_host', host, "Host");
		input_text(program_on, '#jadwal', 'input_jadwal', jadwal, "Schedule");
		input_text_area(program_on, '#desc', desc, "Description");
	});
	
	// Save the edited program
	$('#program_save_edit').on('click', function() {
		// Save the new details
		var iname = $('#input_name').val();
		var ihost = $('#input_host').val();
		var ijadwal = $('#input_jadwal').val();
		var idesc = $('#program_text_area').val();
		
		// Show the ajax animation and hide the save button
		$(this).after("<img src='images/ajax2.gif' style='float:right;margin-top:17px;margin-right:14px'>");
		$(this).hide();
		
		// Do the ajax magic
		$.post("edit.php", {mode: "program", realname: name, name: iname, host: ihost, jadwal: ijadwal, desc: idesc})
		.done(function(data) {
			if (data == "1") { // Success
				$('#name input').parent().html(iname);
				$('#program_host input').parent().html("Host : <span id='italic'>"+ihost+"</span>");
				$('#jadwal input').parent().html(ijadwal);
				$('#desc textarea').parent().html(idesc);
				
				$('#program_save_edit').next().remove();
				$(this).hide();
				$('#normal_buttons').show();
				
				alert("Success on editing data !");
			} else { // Failed
				$('#name input').parent().html(name);
				$('#program_host input').parent().html("Host : <span id='italic'>"+host+"</span>");
				$('#jadwal input').parent().html(jadwal);
				$('#desc textarea').parent().html(desc);
				
				$('#program_save_edit').next().remove();
				$(this).hide();
				$('#normal_buttons').show();
				
				alert("Failed on editing data !");
			}
		});
	});
	
	// Delete program
	$('#program_delete').on('click', function() {
		var c = confirm("Are you sure you want to delete this program ?");
		if (c == true) {
			var url = "delete.php";
			
			// Find the program that is shown
			var program_on = $('.program_desc').filter(function() {
				var match = 'block';
				
				return ($(this).css('display') == match);
			});
			
			var dnama = program_on.find('#name').html();
			var dgambar = program_on.find('#gambar').html();
			var form = $('<form action="'+url+'" method="POST" id="form_delete" style="display:none">' +
				'<input type="text" name="nama" value="'+dnama+'">' +
				'<input type="text" name="gambar" value="'+dgambar+'">' +
				'<input type="text" name="mode" value="program">' +
				'</form>'
			);
			
			$('body').append(form);
			$('#form_delete').submit();
		}
	});
	
	// Close the program description
	$('#program_close').on('click', function() {
		// Revert the form if edit button was clicked
		$('#name input').parent().html(name);
		$('#program_host input').parent().html("Host : <span id='italic'>"+host+"</span>");
		$('#jadwal input').parent().html(jadwal);
		$('#desc textarea').parent().html(desc);
		
		// Show edit and delete buttons, hide save button (if edit / add new button was clicked)
		$('#program_admin_header').html("");
		$('#program_admin_header').removeClass("program_add");
		
		// Hide the details
		$('#program_add').fadeOut('slow');
		$('.program_desc').fadeOut('slow');
		$('#program_desc_container').delay(600).slideUp('slow');
		$('#program_desc_bg').delay(600).fadeOut('slow');
		$('#normal_buttons').fadeOut('slow');
		$('#program_save_edit').fadeOut('slow');
		$('#program_save_add').fadeOut('slow');
	});
	
	// Tidy last row in program slot
	var program_size = $('.program_slot').length;
	
	if (program_size % 3 == 1) {
		$('.program_slot:last-child').addClass('last_row_single');
	} else if (program_size % 3 == 2) {
		$('.program_slot:last-child').addClass('last_row_last').prev().addClass('last_row_first');
	}
});