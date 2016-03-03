(function($) {
    var $message = $('.jqnm_message');

    function hideAllMessages() {
        var messageHeight = $message.outerHeight();
        $message.css('top', -messageHeight); // move element outside viewport
    }

    function showMessage() {
        hideAllMessages();
        $message
            .delay(parseInt(jqnm_script_vars.delay))
            .animate({ top: parseInt(jqnm_script_vars.offset) }, parseInt(jqnm_script_vars.speed));
    }

    $(document).ready(function() {

        console.log(jqnm_script_vars, 'jqnm_script_vars');
        // Initially, hide them all
        hideAllMessages();

        // Show message
        showMessage();

        // When the close btn is clicked, hide the message
        $message.find('.jqn-close').click(function() {
            $message.animate({ top: -$message.outerHeight() }, parseInt(jqnm_script_vars.speed));
        });

        // If message is clicked, hide it
        if (jqnm_script_vars.close_button == 0) {
            $message.click(function() {
                $(this).animate({ top: -$(this).outerHeight() }, parseInt(jqnm_script_vars.speed));
            });
        }

        if (jqnm_script_vars.autohide == 1) {
            setTimeout(function() {
                $message.animate({ top: -$message.outerHeight() }, parseInt(jqnm_script_vars.speed));
            }, jqnm_script_vars.hidedelay);
        }

    });
})(jQuery);
