$(document).ready(function() {
	/****************
		 Gallery
	*****************/
	// Hide the gallery description
	$('#gallery_desc_bg').hide();
	$('#gallery_desc_container').hide();
	$('.gallery_desc').hide();
	$('#gallery_add').hide();
	$('#category_add_edit').hide();
	$('#category_add').hide();
	$('#category_edit').hide();
	
	// Resize images in gallery_slot if exceed 250x130
	$('.gallery_slot img').each(function() {
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
	$('.gallery_desc img').each(function() {
		$(this).load(function() {
			if (this.width > 750 || this.height > 423) {
				if (this.width > this.height)
					$(this).width(750);
				else
					$(this).height(423);
					
				var css = {
					position: 'relative',
					top: '50%',
					//marginTop: '-' + (parseInt($(this).height()) / 2) + 'px',					
					left: '50%',
					marginLeft: '-' + (parseInt($(this).width()) / 2) + 'px'
				};
				$(this).css(css);
			}
		});
	});
	
	// Initialize variables for gallery
	var name;
	
	// Show the gallery description from the corresponding image
	$('.gallery_slot').on('click', function() {
		var index = $('#gallery_slot_container div').index(this);
		
		$('#gallery_desc_bg').fadeIn('slow');
		$('#gallery_desc_container').slideDown('slow');
		$('.gallery_desc').eq(index).delay(600).fadeIn('slow');
		$('#normal_buttons').delay(600).fadeIn('slow');
	});
	
	// Add new gallery
	$('#gallery_add_new').on('click', function() {
		// Hide normal buttons, show save button, change admin header
		$('#normal_buttons').fadeOut('slow');
		$('#gallery_save_add').fadeIn('slow');
		$('#gallery_admin_header').html("Add New Data");
		$('#gallery_admin_header').addClass("gallery_add");
		
		// Show add gallery form
		$('#gallery_desc_bg').fadeIn('slow');
		$('#gallery_desc_container').slideDown('slow');
		$('#gallery_add').delay(600).fadeIn('slow');
	});
	
	// Function to change data to form (input text and text area)
	var input_text = function($parent, $child, $id, $value, $placeholder) {
		$parent.find($child).html("<input type='text' id='"+$id+"' value='"+$value+"' size='15' placeholder='"+$placeholder+"'>");
	};
	
	// Edit gallery
	$('#gallery_edit').on('click', function() {
		// Hide edit and delete buttons, show save button, change admin header
		$('#normal_buttons').fadeOut('slow');
		$('#gallery_save_edit').delay(800).fadeIn('slow');
		$('#gallery_admin_header').html("Edit Data");
		
		// Find the gallery that is shown
		var gallery_on = $('.gallery_desc').filter(function() {
			var match = 'block';
			
			return ($(this).css('display') == match);
		});
		
		// Save the gallery details
		name = gallery_on.find('#gallery_name #name').html();
		
		// Change into form
		input_text(gallery_on, '#name', 'input_name', name, "Name");
	});
	
	// Save the edited gallery
	$('#gallery_save_edit').on('click', function() {
		// Save the new details
		var iname = $('#input_name').val();
		
		// Show the ajax animation and hide the save button
		$(this).after("<img src='images/ajax2.gif' style='float:right;margin-top:17px;margin-right:14px'>");
		$(this).hide();
		
		// Find the gallery that is shown
		var gallery_on = $('.gallery_desc').filter(function() {
			var match = 'block';
			
			return ($(this).css('display') == match);
		});
		
		var ID = gallery_on.find('#gallery_ID').val();
		
		// Do the ajax magic
		$.post("edit.php", {mode: "gallery", ID: ID, name: iname})
		.done(function(data) {
			if (data == "1") { // Success
				$('#name input').parent().html(iname);
				
				$('#gallery_save_edit').next().remove();
				$(this).hide();
				$('#normal_buttons').show();
				
				alert("Success on editing data !");
			} else { // Failed
				$('#name input').parent().html(name);
				
				$('#gallery_save_edit').next().remove();
				$(this).hide();
				$('#normal_buttons').show();
				
				alert("Failed on editing data !");
			}
		});
	});
	
	// Delete gallery
	$('#gallery_delete').on('click', function() {
		var c = confirm("Are you sure you want to delete this picture ?");
		if (c == true) {
			var url = "delete.php";
			
			// Find the gallery that is shown
			var gallery_on = $('.gallery_desc').filter(function() {
				var match = 'block';
				
				return ($(this).css('display') == match);
			});
			
			var dID = gallery_on.find('#ID').html();
			var dCat = gallery_on.find('#category').html();
			var dGambar = gallery_on.find('#gambar').html();
			var form = $('<form action="'+url+'" method="POST" id="form_delete" style="display:none">' +
				'<input type="text" name="ID" value="'+dID+'">' +
				'<input type="text" name="category" value="'+dCat+'">' +
				'<input type="text" name="gambar" value="'+dGambar+'">' +
				'<input type="text" name="mode" value="gallery">' +
				'</form>'
			);
			
			$('body').append(form);
			$('#form_delete').submit();
		}
	});
	
	// Close the gallery description
	$('#gallery_close').on('click', function() {
		// Show edit and delete buttons, hide save button (if edit / add new button was clicked)
		$('#gallery_admin_header').html("");
		$('#gallery_admin_header').removeClass("gallery_add");
		
		// Hide the details
		$('#gallery_add').fadeOut('slow');
		$('.gallery_desc').fadeOut('slow');
		$('#gallery_desc_container').delay(600).slideUp('slow');
		$('#gallery_desc_bg').delay(600).fadeOut('slow');
		$('#normal_buttons').fadeOut('slow');
		$('#gallery_save_edit').fadeOut('slow');
		$('#gallery_save_add').fadeOut('slow');
	});
	
	// Tidy last row in gallery slot and category slot
	var gallery_size = $('.gallery_slot, .gallery_category_slot').length;
	
	if (gallery_size % 3 == 1) {
		$('.gallery_slot:last-child, .gallery_category_slot:last-child').addClass('last_row_single');
	} else if (gallery_size % 3 == 2) {
		$('.gallery_slot:last-child, .gallery_category_slot:last-child').addClass('last_row_last').prev().addClass('last_row_first');
	}
	
	// Open the add category section
	$('#gallery_category_add_new').on('click', function() {
		$('#category_admin_header').html("Add Category");
		$('#category_add').show();
		$('#category_add_edit').slideDown('slow');
	});
	
	// Open the edit category section
	$('#gallery_category_edit').on('click', function() {
		$('#category_admin_header').html("Edit Category");
		$('#category_edit').show();
		$('#category_add_edit').slideDown('slow');
	});
	
	// Close the add / edit category section
	$('#category_edit_cancel, #category_cancel_add').on('click', function() {
		$('#category_add_edit').slideUp('slow');
		$('#category_edit').delay(800).hide();
		$('#category_add').delay(800).hide();
	});
	
	// Edit Category
	$('.category_edit_save').on('click', function() {
		// Save the new details
		var count = $(this).attr('name');
		var iname = $('#nama'+count).val();
		var ID = $('#ID'+count).val();
		
		var the_button = $(this);
		
		// Show the ajax animation and hide the save button
		$(this).after("<img src='images/ajax2.gif' style='float:right;margin-right:17px'>");
		$(this).hide();
		
		// Do the ajax magic
		$.post("edit.php", {mode: "category", ID: ID, nama: iname})
		.done(function(data) {
			if (data == "1") { // Success				
				the_button.next().remove();
				the_button.show();
				
				alert("Success on editing data !");
			} else { // Failed				
				the_button.next().remove();
				the_button.show();
				
				alert("Failed on editing data !");
			}
		});
	});
	
	// Delete Category
	$('.category_delete').on('click', function() {
		// Save the new details
		var count = $(this).attr('name');
		var ID = $('#ID'+count).val();
		var iname = $('#nama'+count).val();
		var the_button = $(this);
		
		var c = confirm("Are you sure you want to delete Category '"+iname+"' ?");
		if (c) {
			// Show the ajax animation and hide the save button
			$(this).after("<img src='images/ajax2.gif' style='float:right;margin-right:17px'>");
			$(this).hide();
			
			// Do the ajax magic
			$.post("delete.php", {mode: "category", ID: ID})
			.done(function(data) {
				if (data == "1") { // Success				
					the_button.parents('tr').remove();
					
					alert("Success on deleting data !");
				} else { // Failed				
					the_button.next().remove();
					the_button.show();
					
					alert("Failed on deleting data !");
				}
			});
		}
	});
});