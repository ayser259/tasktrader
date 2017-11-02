//JavaScript for TaskTrader

$(document).ready(function() {

	$('#tag').tagsInput();
	$('#tags').tagsInput();

	$('.profile_section').click(function() {
		$('.profile_section').removeClass('active');
		$(this).addClass('active');
		var $id = $(this).attr('name');
		$('.profile_info').each(function(){
			if (!$(this).is($id)) {
				$(this).removeClass('show_form');
			}	
		});
		if (!$('#' +$id).hasClass('show_form')){
			$('#' +$id).addClass('show_form');
		}
	});

	setTimeout(function(){ 
		$('.update_message').fadeOut(300, function() { $(this).remove(); });
	 }, 3000);
 
});