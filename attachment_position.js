rcmail.addEventListener('init', function() {
	if (rcmail.env.action == 'compose') { //only run when composing a message
		// get attachments pane element 
		var elAttachments = $('#compose-attachments div');
		
		if (rcmail.env.attachment_position === 'top') {
			if ('undefined' == typeof rcmail.env.rcs_mobile || rcmail.env.rcs_mobile !== true) {
				// move the attachments pane to the top if settings dictate
				// only move if we're not switched to the mobile skin
				attachment_position_move_pane();
			}
		} else {
			// default position - add arrow to allow for moving on demand
			// create a link with an arrow in it which will move the position on click
			var el = $('<a href="#"></a>');
			el.on('click', function() {
				attachment_position_move_pane();
				return false;
			})
			.attr('title', rcmail.gettext('addattachmentpositionmovetop', 'attachment_position'))
			.append($('<span id="attachment_position_move" class="arrow"></span>'));
			
			// append move arrow to attachments pane when in default position
			elAttachments.first().append(el);
		}
	}
});

function attachment_position_move_pane()
{
	var elAttachments = $('#compose-attachments'); // get attachment pane
	elAttachments.detach();                        // detach from DOM
	elAttachments.appendTo('div#composeheaders');  // move to top position
	$('#composebodycontainer').addClass('attachment_position');
	$('#attachment_position_move').hide();         // hide move arrow, if exists
        elAttachments.find('div.hint').after('<br>');
	
	$('#composebody_ifr').resize();                // trigger resize to fix width
	
}
