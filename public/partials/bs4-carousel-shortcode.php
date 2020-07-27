<?php
add_shortcode( 'bs4_carousel', 'output_bs4_carousel' );
function output_bs4_carousel( $atts ) {
	// Shortcode Attributes Inputs:
    $atts = shortcode_atts(
		array(
			'name' => false,
		), 
		$atts,
		'bs4_carousel'
	);

	wp_enqueue_script( 'popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array( 'jquery' ), '1.16.0', false );
	wp_enqueue_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array( 'jquery' ), '4.5.0', false );

	// Shortcode Attribute Input Variables:
	$slider_name = ( $atts['name'] !== false ) ? $atts['name'] : false;

	// Global Plugin Variable Options:
	$bs4c_global_options = get_option( 'bs4c_options_page' );
	$disable_lazyload = ( isset( $bs4c_global_options['skip-lazyload-class'] ) ) ? " {$bs4c_global_options['skip-lazyload-class']}" : '';

	// If the name input is not false and not empty run script, else return false:
	if ( $slider_name !== false && !empty( $slider_name ) ) {
		// Wordpress get post ID query (for carousels):
		$get_post_id_args = array(
			'post_type' => 'carousel',
			'numberposts' => 1,
			'post_name__in' => $slider_name,
		);
		$slider_id = get_posts( $get_post_id_args )[0]->ID;

		// If the wordpress get post id query returns an integer build the output, else return false:
		if ( is_integer( $slider_id ) ) {
			// Slider Content Data Arrays:
			$slider_gen_settings = rwmb_meta( 'bs4c_gen_settings', '', $slider_id );
			$slider_content = rwmb_meta( 'bs4c_slides', '', $slider_id );

			// Slider Output Boolean Variable Settings:
			$arrows_enabled = ( isset( $slider_gen_settings['arrows'] ) && $slider_gen_settings['arrows'] == 1 ) ? true : false;
			$nav_enabled = ( isset( $slider_gen_settings['nav'] ) && $slider_gen_settings['nav'] == 1 ) ? true : false;
			$hide_mobile = ( isset( $slider_gen_settings['hide_mobile'] ) && $slider_gen_settings['hide_mobile'] == 1 ) ? " d-none d-md-block" : false;
			$transition = ( isset( $slider_gen_settings['tran_type'] ) && $slider_gen_settings['tran_type'] == 'fade' ) ? " carousel-fade" : '';

			// Arrows Output:
			if ( $arrows_enabled ) {
				$arrows_output = 
					"<a class='carousel-control-prev' href='#{$slider_name}' role='button' data-slide='prev'>
						<span class='carousel-control-prev-icon' aria-hidden='true'></span>
						<span class='sr-only'>Previous</span>
					</a>
					<a class='carousel-control-next' href='#{$slider_name}' role='button' data-slide='next'>
						<span class='carousel-control-next-icon' aria-hidden='true'></span>
						<span class='sr-only'>Next</span>
					</a>";
			}
			else {
				$arrows_output = '';
			}

			// Slider Container - Start:
			$sliderBefore = 
			"<!-- Yeah dawg, this slider is the result of a plugin I developed just for my custom Understrap Child Theme. If you're interested in using it. Hit the contact me page. -->
			<div id='{$slider_name}' class='carousel slide{$transition}{$hide_mobile}' data-ride='carousel'>";

		# Foreach Slider Content:

			// Slider Inner Content Start:
			$sliderInnerContent_start = "<div class='carousel-inner'>";
			// Contents Empty Variables to Append Output to.
			$slider_nav_indicators = '';
			$slidesOutput = '';

			foreach ( $slider_content as $slideIndex => $slideContent ) {
				// First Slide Active Variable:
				$slide_active = ( $slideIndex == 0 ) ? 'active' : '';

				// Loop the Navigation Icons:
				if ( $nav_enabled ) {
					$slider_nav_indicators .= "<li data-target='#{$slider_name}' data-slide-to='{$slideIndex}' class='{$slide_active}'></li>";
				}
				else { $slider_nav_indicators = ''; }

			# Slide Variables:
				// Image Variables:
				$imageID = ( isset( $slideContent['slide_image'] ) && !empty( $slideContent['slide_image'] ) ) ? $slideContent['slide_image'] : '';
				$slideImage = ( !empty( $imageID ) ) ? wp_get_attachment_image( $imageID, 'full', false, array( 'class' => "d-block w-100{$disable_lazyload}" ) ) : '';
				// Orientation Variables:
				$orientation = ( isset( $slideContent['orientation'] ) && !empty( $slideContent['orientation'] ) ) ? $slideContent['orientation'] : '';
				if ( !empty( $orientation ) && $orientation == 'top-left' ) { $orientation_class = "align-items-start justify-content-start"; }
				else if ( !empty( $orientation ) && $orientation == 'top-center' ) { $orientation_class = "align-items-center justify-content-start"; }
				else if ( !empty( $orientation ) && $orientation == 'top-right' ) { $orientation_class = "align-items-end justify-content-start"; }
				else if ( !empty( $orientation ) && $orientation == 'center-left' ) { $orientation_class = "align-items-start justify-content-center"; }
				else if ( !empty( $orientation ) && $orientation == 'centered' ) { $orientation_class = "align-items-center justify-content-center"; }
				else if ( !empty( $orientation ) && $orientation == 'center-right' ) { $orientation_class = "align-items-end justify-content-center"; }
				else if ( !empty( $orientation ) && $orientation == 'bottom-left' ) { $orientation_class = "align-items-start justify-content-end"; }
				else if ( !empty( $orientation ) && $orientation == 'bottom-center' ) { $orientation_class = "align-items-center justify-content-end"; }
				else if ( !empty( $orientation ) && $orientation == 'bottom-right' ) { $orientation_class = "align-items-end justify-content-end"; }
				else { $orientation_class = "align-items-center justify-content-center"; }

				// Content Variables:
				$heading = ( isset( $slideContent['slide_heading'] ) && !empty( $slideContent['slide_heading'] ) ) ? $slideContent['slide_heading'] : '';
				$heading_css = ( isset( $slideContent['heading_css'] ) && !empty( $slideContent['heading_css'] ) ) ? $slideContent['heading_css'] : '';
				$subheading = ( isset( $slideContent['slide_subheading'] ) && !empty( $slideContent['slide_subheading'] ) ) ? $slideContent['slide_subheading'] : '';
				$subheading_css = ( isset( $slideContent['subheading_css'] ) && !empty( $slideContent['subheading_css'] ) ) ? $slideContent['subheading_css'] : '';
				$content = ( isset( $slideContent['slide_content'] ) && !empty( $slideContent['slide_content'] ) ) ? $slideContent['slide_content'] : '';
				// Link Variables:
				$link_type = ( isset( $slideContent['link_type'] ) && !empty( $slideContent['link_type'] ) ) ? $slideContent['link_type'] : '';
				$button_text = ( isset( $slideContent['button_text'] ) && !empty( $slideContent['button_text'] ) ) ? $slideContent['button_text'] : '';
				$button_css = ( isset( $slideContent['button_class'] ) && !empty( $slideContent['button_class'] ) ) ? $slideContent['button_class'] : 'btn-primary';
				$slideLinkID = ( isset( $slideContent['slide_link'] ) && !empty( $slideContent['slide_link'] ) ) ? $slideContent['slide_link'] : '';
				$slideLink = ( !empty( $slideLinkID ) ) ? get_the_permalink( $slideLinkID ) : "#";
				$slideLinkTitle = ( !empty( $slideLinkID ) ) ? get_the_title( $slideLinkID ) : "";

				// Link Type Output:
				if ( $link_type == 'button' ) {
					$linkStart = "<a href='{$slideLink}' class='btn {$button_css}' title='{$slideLinkTitle}'>";
					$linkStart .= ( !empty( $button_text ) ) ? $button_text : '';
					$linkEnd = "</a>";
				}
				else if ( $link_type == 'image' ) {
					$linkStart = "<a href='{$slideLink}' class='' title='{$slideLinkTitle}'>";
					$linkEnd = "</a>";
				}
				else {
					$linkStart = "";
					$linkEnd = "";
				}

				// Open the side item:
				$slidesOutput .= "<div class='carousel-item {$slide_active}'>";

				// Start the slide content:

				// Whole Image Link Condition Start:
				if ( $link_type == 'image' ) {
					$slidesOutput .= $linkStart;
				}

				// The Slide Image:
				$slidesOutput .= $slideImage;

				// Compile the Overlay Content:
				if ( !empty( $heading ) || !empty( $subheading ) || !empty( $content ) || $link_type == 'button' ) {
					$slidesOutput .= "<div class='carousel-caption h-100 d-flex flex-column pt-5 px-3 {$orientation_class}'>";
					$slidesOutput .= ( !empty( $heading ) ) ? "<h2 class='{$heading_css}'>{$heading}</h2>" : '';
					$slidesOutput .= ( !empty( $subheading ) ) ? "<h3 class='{$subheading_css}'>{$subheading}</h3>" : '';
					$slidesOutput .= ( !empty( $content ) ) ? "<div>{$content}</div>" : '';
					$slidesOutput .= ( $link_type == 'button' ) ? $linkStart . $linkEnd : '';
					$slidesOutput .= "</div>";
				}

				// Whole Image Link Condition End:
				if ( $link_type == 'image' ) {
					$slidesOutput .= $linkEnd;
				}

				// Close the Slide Item:
				$slidesOutput .= "</div>";

				$slideExample = array (
					'slide_image' => 28,
					'orientation' => 'centered',
					'slide_heading' => 'Slide Heading 1',
					'slide_subheading' => 'Slide Subheading 1',
					'slide_content' => 'Slide 1 Sample Content',
					'link_type' => 'button',
					'button_text' => 'Learn More',
					'slide_link' => 2,
				);
			}

			$sliderInnerContent_end = "</div>";

			// Slide Navigation Indicator Icons Output:
			$slider_nav = ( $nav_enabled ) ? "<ol class='carousel-indicators'>{$slider_nav_indicators}</ol>" : '';

			// Slider Closing Tag:
			$sliderAfter = '</div>';

			$return_slider = $sliderBefore . $slider_nav . $sliderInnerContent_start . $slidesOutput . $sliderInnerContent_end . $arrows_output . $sliderAfter;
		}
		else {
			$return_slider = false;
		}
	}
	else {
		$return_slider = false;
	}
    return $return_slider;
}