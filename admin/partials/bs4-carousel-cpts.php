<?php
/*--------------------- Register the Custom Post Type For Carousel ---------------------*/
add_action( 'init', 'bs4_carousel_cpt' );
function bs4_carousel_cpt() {
	register_post_type( 'carousel', array(
		'labels' => array(
			'name' => _x( 'Carousels', 'Carousels', 'text_domain' ),
			'singular_name' => _x( 'Carousel', 'Carousel', 'text_domain' ),
		),
		'supports' => array( 'title' ),
		'taxonomies' => array( 'category' ),
		'hierarchical' => true,
		'description' => 'Carousels',
		'public' => true,
		'show_in_menu' => 'bs4_carousels',
		'position' => 1,
	));
}
/*----------------- Add Metaboxes to Carousels CPT -----------------*/
add_filter( 'rwmb_meta_boxes', 'bs4_carousel_add_metaboxes' );
function bs4_carousel_add_metaboxes( $meta_boxes ) {
    $prefix = 'bs4c_';
    $meta_boxes[] = array(
        'title'      => 'Carousel',
        'post_types' => 'carousel',
        'context'    => 'after_title',
        'priority'   => 'high',
        'fields' => array(
                array(
                    'id' => $prefix . 'carousel',
                    'group_title' => 'Slide {#}',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'collapsible' => true,
                    'max_clone' => 10,
                    'add_button' => '+ Add New Slide',
                    'fields' => array(
                        array(
                            'id'   => 'slide_image',
                            'type' => 'single_image',
                            'name' => 'Slide Image',
                        ),
                        array(
                            'id' => 'slide_heading',
                            'name' => 'Slide Heading',
                            'type' => 'text',
                        ),
                        array(
                            'id' => 'slide_subheading',
                            'name' => 'Slide Subheading',
                            'type' => 'text',
                        ),
                        array(
                            'id'      => 'slide_content',
                            'name'    => 'Slide Content',
                            'type'    => 'wysiwyg',
                            'raw'     => false,
                            'options' => array(
                                'textarea_rows' => 4,
                                'teeny'         => true,
                            ),
                        ),
                        array(
                            'id' => 'link_type',
                            'name' => 'Link Type',
                            'type' => 'select',
                            'options' => array(
                                'no-link' => 'Do not link',
                                'image' => 'Entire Image',
                                'button' => 'Button Link',
                            ),
                        ),
                        array(
                            'id' => 'button_text',
                            'name' => 'Button Text',
                            'type' => 'text',
                            'hidden' => array('link_type', '!=', 'button'),
                        ),
                        array(
                            'id' => 'slide_link',
                            'name' => 'Select link destination',
                            'type' => 'post',
                            'post_type' => array('post', 'page', 'attachment'),
                            'field_type' => 'select_advanced',
                            'placeholder' => 'Select a page',
                            'query_args' => array(
                                'post_status' => 'publish',
                                'posts_per_page' => - 1,
                            ),
                            'hidden' => array( 'link_type', '=', 'no-link' ),
                        ),
                    ),
                ),
            ),
    	);
    return $meta_boxes;
}
