<?php
function bs4_carousel_top_level_admin_menu() {
	add_menu_page(
		__( 'Bootstrap 4 Carousels', 'textdomain' ),
		'Bootstrap 4 Carousels',
		'edit_posts',
		'bs4_carousels',
		'',
		'dashicons-images-alt2',
		6
	);
}
add_action( 'admin_menu', 'bs4_carousel_top_level_admin_menu' );