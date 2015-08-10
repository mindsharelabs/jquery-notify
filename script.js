(function($){
	function hideAllMessages()
	{
			  var messageHeight = $('.jqnm_message').outerHeight();
			  $('.jqnm_message').css('top', -messageHeight); //move element outside viewport	  
	}

	function showMessage()
	{
			hideAllMessages();
			$('.jqnm_message').delay(parseInt(jqnm_script_vars.delay)).animate({top: parseInt(jqnm_script_vars.offset)}, parseInt(jqnm_script_vars.speed));
	}

	$(document).ready(function(){
			 // Initially, hide them all
			 hideAllMessages();
		 
			 // Show message
			showMessage();
		 
			 // When message is clicked, hide it
			 $('.jqnm_message').click(function(){			  
					  $(this).animate({top: -$(this).outerHeight()}, parseInt(jqnm_script_vars.speed));
			  });	
			
			if(jqnm_script_vars.autohide == 1) {
				setTimeout(function(){
				  $('.jqnm_message').animate({top: -$('.jqnm_message').outerHeight()}, parseInt(jqnm_script_vars.speed));
				},jqnm_script_vars.hidedelay);
			}
				 		 
	});
})(jQuery);