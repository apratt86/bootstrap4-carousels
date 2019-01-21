<?php
// Register settings page.
add_filter( 'mb_settings_pages', 'bs4c_options_page' );
function bs4c_options_page( $settings_pages ) {
	$settings_pages[] = array(
		'id'          => 'bs4c_options_page',
		'option_name' => 'bs4c_options_page',
		'menu_title'  => 'Settings',
		'parent'			=> 'bs4_carousels',
		'style'       => 'boxes',
		'columns'     => 1,
		'tabs'        => array(
			'advanced' => 'Advanced Settings',
		),
		'position'    => 68,
	);
	return $settings_pages;
}

// Register meta boxes and fields for settings page
add_filter( 'rwmb_meta_boxes', 'prefix_options_meta_boxes' );
function prefix_options_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'id'             => 'advanced',
        'title'          => 'Advanced Settings',
        'settings_pages' => 'bs4c_options_page',
        'tab'            => 'advanced',
        'fields' => array(
            array(
                'id'   => 'skip-lazyload-class',
                'name' => 'Skip Lazy Loading CSS Class',
                'type' => 'text',
            ),
        ),
    );
    return $meta_boxes;
}
