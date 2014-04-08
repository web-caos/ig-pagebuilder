/**
 * @version    $Id$
 * @package    IG_Library
 * @author     InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 InnoGears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 * Technical Support: Feedback - http://www.innogears.com/contact-us/get-support.html
 */

// Declare InnoGears Upgrade class
(function($) {
	IG_Pb_Settings = function(params) {
		// Object parameters
		this.params = $.extend({}, params);

        $(document).ready($.proxy(function() {
			var params_ = this.params;
			// Get update button object
			this.button = document.getElementById(params_.button);

			// Set event handler to update product
			$(this.button).click($.proxy(function(event) {
				event.preventDefault();
				this.clear_cache(params_);
			}, this));
		}, this));
	};

	// Declare methods
	IG_Pb_Settings.prototype = {
		clear_cache: function(params_) {
            var loading = params_.loading;
            var message = params_.message;
            loading.toggleClass('hidden');

			$.post(
                params_.ajaxurl,
                {
                    action 		: 'igpb_clear_cache',
                    ig_nonce_check : params_._nonce
                },
                function(data) {
                    loading.toggleClass('hidden');
                    message.html(data).toggleClass('hidden');
                    setTimeout(function(){
                        message.toggleClass('hidden');
                    }, 3000 );
                }
            );
		}
	};
})(jQuery);
