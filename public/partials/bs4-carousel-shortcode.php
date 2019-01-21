<?php
add_shortcode( 'bs4_carousel', 'output_bs4_carousel' );
function output_bs4_carousel( $atts ) {
    $atts = shortcode_atts(
			array(
                'carousel_id' => false,
                'carousel_slug' => false,
                'carousel_name' => false,
				'arrows' => true,
				'nav' => true,
				'max' => 6,
				'link' => true,
				'fade' => false
			), 
			$atts,
			'bs4_carousel'
        );
    
	// Arrow Navigation:
	if( (boolean)$atts['arrows'] ){
		$arrows = 
		"<a class='carousel-control-prev' href='#couponSlide' role='button' data-slide='prev' style='text-shadow: 2px 2px 3px #000;'>
			<span class='carousel-control-prev-icon' aria-hidden='true' style='text-shadow: 2px 2px 3px #000;'></span>
			<span class='sr-only' style='text-shadow: 2px 2px 3px #000;'>Previous</span>
		</a>
		<a class='carousel-control-next' href='#couponSlide' role='button' data-slide='next' style='text-shadow: 2px 2px 3px #000;'>
			<span class='carousel-control-next-icon' aria-hidden='true' style='text-shadow: 2px 2px 3px #000;'></span>
			<span class='sr-only' style='text-shadow: 2px 2px 3px #000;'>Next</span>
		</a>";
	}
	else{
		$arrows = "";
	}
	
	// Cross Fade Effect:
	if ( (boolean)$atts['fade'] ) { $fade = ' carousel-fade'; }
	else{ $fade = ''; }
	
	// Enable Slide Link:
	$linkEnable = ( (boolean)$atts['link'] == true ) ? true : false;
	
	// Get the Coupons:
	$args = array(
		'numberposts' => intval($atts['max']),
		'post_type' => 'coupon'
	);
	
	$coupons = get_posts($args);
	
	// Slider Container START:
	$return_slider =
	"<div id='couponSlide' class='carousel slide my-3{$fade}' data-ride='carousel'>
			<div class='carousel-inner'>";
	
	// Create slide images:
	$slideIndex = 0;
	foreach ($coupons as $coupon){
		$couponDetails = rwmb_meta('coupon_details', '', $coupon->ID);
		$couponLink = get_permalink($coupon->ID);
		$couponTitle = get_the_title($coupon->ID);
		$couponSubheading = ( isset($couponDetails['subheading']) ) ? $couponDetails['subheading'] : '';
		
		$slideEnabled = (isset($couponDetails['ftrd_slide']) && $couponDetails['ftrd_slide'] == 1 ) ? true : false;
		$slideImage = ( isset($couponDetails['slide_img']) && count( $couponDetails['slide_img'] ) == 1 ) ? wp_get_attachment_image($couponDetails['slide_img'][0], 'full', '', array( 'class' => 'no-lazyload d-block w-100' )) : null;
		$slideTextEnable = ( isset($couponDetails['slide_heading']) && $couponDetails['slide_heading'] == true ) ? true : false;
		
		
		if ( $slideTextEnable ) {
			$slideCaption = 
				"<div class='carousel-caption d-none d-md-flex flex-column align-items-center justify-content-center h-100' style='text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.8);'>
					<h5 class='display-4'>{$couponTitle}</h5>
					<h6 class='h4'>{$couponSubheading}</h6>
				</div>";
		}
		else { $slideCaption = ""; }
		
		if ($slideEnabled) {
			if ( $slideIndex == 0 ) {
				$activeSlide = ' active';
			}
			else { $activeSlide = ''; }
			$return_slider .= "<div class='carousel-item{$activeSlide} align-items-center justify-content-center'>";
			if ( $linkEnable ) { $return_slider .= "<a href='{$couponLink}' title='{$couponTitle}'>{$slideImage}{$slideCaption}</a>"; }
			else { $return_slider .= "{$slideImage}{$slideCaption}"; }
			$return_slider .= "</div>";
			$slideIndex ++;
		}
	}
	
	// Navigation Icons:
		$navIndex = 0;
		if ( $atts['nav'] == true ) {
			$return_slider .= "<ol class='carousel-indicators'>";
			foreach ( $coupons as $slide ) {
				if ($slideEnabled) {
					$return_slider .= "<li data-target='#couponSlide' data-slide-to='{$navIndex}' style='box-shadow:2px 2px 3px rgba(0, 0, 0, 0.5);'></li>";
					$navIndex++;
				}
			}
			$return_slider .= "</ol>";
		}
		
	// Slider Container END:
	$return_slider .=
	"</div>
		{$arrows}
	</div>";
	
    return $return_slider;
}