$(document).ready(function() {
	/****************
		  Index
	*****************/
	// Start the image slideshow
	$('#slideshow').fadeSlideShow();
	
	var fssListChild = $('#fssList').children().length;
	$('#fssList').css("margin-left", "-"+27*fssListChild+"px");
	
	$('#slide_admin').hide();
	
	// Show the slide add section
	$('#slide_add_btn').on('click', function() {
		$('#slide_header').html("Add New Slide");
		$('#slide_edit').hide();
		$('#slide_add').show();
		$('#slide_admin').slideDown('slow');
	});
	
	// Hide the slide add section
	$('#slide_add_cancel').on('click', function() {
		$('#slide_admin').slideUp('slow');
	});
	
	// Show the slide edit section
	$('#slide_edit_btn').on('click', function() {
		$('#slide_header').html("Edit Slides");
		$('#slide_add').hide();
		$('#slide_edit').show();
		$('#slide_admin').slideDown('slow');
	});
	
	// Hide the slide edit section
	$('#slide_edit_cancel').on('click', function() {
		$('#slide_admin').slideUp('slow');
	});
	// Lowering the apps section if admin is logged in
	if ($('#admin_bar').length != 0) {
		$('#apps-streaming').css("top", "+=30px");
		$('#follow_us').css("top", "+=30px");
		$('#music_chart').css("top", "+=30px");
		$('#chatbox').css("top", "+=30px");
	}	
	
	// Event handler for logout button
	$('#logout-btn').on('click', function(){
		window.location.href = "logout";
	});
	
	$('#apps-str-btn').on('click', function() {
		var streambox = $('#apps-streaming');
		
		if (streambox.css('top') == "-75px") {
			streambox.animate({
				top: "0px"
			}, 1200, 'easeInOutQuint');
		} else if (streambox.css('top') == "-45px") {
			streambox.animate({
				top: "30px"
			}, 1200, 'easeInOutQuint');
		} else {
			if ($('#admin_bar').length != 0) {
				streambox.animate({
					top: "-45px"
				}, 1200, 'easeInOutQuint');
			} else {
				streambox.animate({
					top: "-75px"
				}, 1200, 'easeInOutQuint');
			}
		}
	});
	
	// Event handler for chatbox button on the right
	$('#chat_button').on('click', function(){
		var chatbox = $('#chatbox');
		
		if (chatbox.css('right') == "-350px") {
			chatbox.animate({
				right: "0px"
			}, 1200, 'easeInOutQuint');
		} else {
			chatbox.animate({
				right: "-350px"
			}, 1200, 'easeInOutQuint');
		}
	});
	
	// Event handler for chart button on the left
	$('#chart_button').on('click', function(){
		var music = $('#music_chart');
		
		if (music.css('left') == "-401px") {
			music.animate({
				left: "0px"
			}, 1200, 'easeInOutQuint');
		} else {
			music.animate({
				left: "-401px"
			}, 1200, 'easeInOutQuint');
		}
	});
	
	$('#chart_edit_save').hide();
	
	$('#chart_edit').on('click', function() {
		$(this).hide();
		$('#chart_edit_save').show();
		
		$('#the_chart_container table').wrap("<form action='edit.php' method='POST' id='chart_form'></form>");
		$('#the_chart_container table').after("<input type='text' name='mode' value='chart' style='display:none'>");
		
		var i = 0;
		$('#the_chart td:first-child').each(function() {
			var value = $(this).html();
			i++;
			$(this).html("<input type='text' name='Pos"+i+"' id='chart_ID' value='"+value+"'>");
		});
		
		var i = 0;
		$('#the_chart td:nth-child(2)').each(function() {
			var value = $(this).html();
			i++;
			$(this).html("<input type='text' name='ID"+i+"' value='"+value+"' style='display:none'>");
		});
		
		i = 0;
		$('#the_chart td:nth-child(3)').each(function() {
			var value = $(this).html();
			i++;
			$(this).html("<input type='text' name='Song"+i+"' value=\""+value+"\">");
		});
		
		i = 0;
		$('#the_chart td:last-child').each(function() {
			var value = $(this).html();
			i++;
			$(this).html("<input type='text' name='Artist"+i+"' value=\""+value+"\">");
		});
	});
	
	$('#chart_edit_save').on('click', function() {		
		$('#chart_form').submit();
	});
	
	// Resize images in index_event if exceed 152x140
	$('.index_event_content img').each(function() {
		$(this).load(function() {
			if (this.height > 140) {
				$(this).height(140);
					
				var css = {
					position: 'relative',
					/*top: '50%',
					marginTop: '-' + (parseInt($(this).height()) / 2) + 'px',*/
					left: '50%',
					marginLeft: '-' + (parseInt($(this).width()) / 2) + 'px'
				};
				$(this).css(css);
			}
		});
	});
	
	// Hide all event descriptions
	$('.index_event_content div').hide();
	
	// Show the selected event description
	$('.index_event_content').on('mouseenter', function() {
		var desc = $("div", this);
		
		desc.slideDown('slow');
	});
	
	// Hide the recently selected event description
	$('.index_event_content').on('mouseleave', function() {
		var desc = $("div", this);
		
		desc.slideUp('slow');
	});
});