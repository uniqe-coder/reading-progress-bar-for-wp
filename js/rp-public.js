( function reading_progress_bar_for_wp( $) {
	// The DOM needs to be fully loaded (including graphics, iframes, etc)
	$(window).on("load", function reading_progress_bar_for_wp_inner() {
		// rpbforwp
		// Maximum value for the progressbar
		var winHeight=$(window).height(), docHeight=$(document).height();
		var max=docHeight - winHeight;
		$('.rp_bar').attr('max', max); // adds max attribute with value
		var rpbforwp_up_layer=$('.rp_bar').attr('up_layer');
		var progressBackground=$('.rp_bar').attr('background');
		var rpbforwp_height=$('.rp_bar').attr('height');
		var Pr_pos=$('.rp_bar').attr('position');
		//var progressCustomPosition = $('.rp_bar').attr('data-custom-position');
		var progressFixedOrAbsolute='fixed';
		// Custom position
		if (Pr_pos=='custom') {
			console.log(progressCustomPosition);
			$('.rp_bar').appendTo(progressCustomPosition);
			Pr_pos='bottom';
			progressFixedOrAbsolute='absolute';
		}
		// Styles
		if ( Pr_pos=='top') {
			var progressTop='0';
			var progressBottom='auto';
		}
		else {
			var progressTop='auto';
			var progressBottom='0';
		}
		$('.rp_bar').css( {
			'background-color': progressBackground, 'color': rpbforwp_up_layer, 'height': rpbforwp_height + 'px', 'top': progressTop, 'bottom': progressBottom, 'position': progressFixedOrAbsolute, 'display': 'block'
		}
		);
		$('<style>.rp_bar::-webkit-progress-bar { background-color: transparent } .rp_bar::-webkit-progress-value { background-color: ' + rpbforwp_up_layer + ' } </style>') .appendTo('head');
		// Inital value (if the page is loaded within an anchor)
		var value=$(window).scrollTop();
		//$('.rp_bar').attr('value', value);
		// Maths & live update of progressbar value
		$(document).on('scroll', function get_vertical_pos() {
			value=$(window).scrollTop(); // returns Vertical pos
			$('.rp_bar').attr('value', value);
		}
		);
	}
	);
}

)( jQuery);