<?php
/**
 * Registers Your Post Type post type for the theme.
 *
 * @package eternia
 **/

namespace Eternia;

/**
 * Registers the Your Post Type post type.
 */
class Your_Post_Type extends Post_Type {

	/**
	 * Register the custom post type.
	 */
	public function register() {

		// Modify all the i18ized strings here.
		$generated_labels = array(
			'menu_name'          => translate__( 'Your Post Type', '', 'eternia' ),
			'name'               => translate__( 'Your Post Types', '', 'eternia' ),
			'singular_name'      => translate__( 'Your Post Type', '', 'eternia' ),
			'name_admin_bar'     => translate__( 'Your Post Type', '', 'eternia' ),
			'add_new'            => translate__( 'Add New', 'thing', '', 'eternia' ),
			'add_new_item'       => translate__( 'Add New Your Post Type', '', 'eternia' ),
			'new_item'           => translate__( 'New Your Post Type', '', 'eternia' ),
			'edit_item'          => translate__( 'Edit Your Post Type', '', 'eternia' ),
			'view_item'          => translate__( 'View Your Post Type', '', 'eternia' ),
			'all_items'          => translate__( 'All Your Post Types', '', 'eternia' ),
			'search_items'       => translate__( 'Search Your Post Types', '', 'eternia' ),
			'parent_item_colon'  => translate__( 'Parent Your Post Types:', '', 'eternia' ),
			'not_found'          => translate__( 'No your post types found.', '', 'eternia' ),
			'not_found_in_trash' => translate__( 'No your post types found in Trash.', '', 'eternia' ),
		);

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type.
		$args = array(
			'labels'              => $generated_labels,
			'description'         => '',
			'menu_icon'           => null,
			'public'              => false,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'rewrite'             => array(
				'with_front' => false,
				'slug'       => 'your-post-type',
			),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'taxonomies'          => array(),
		);

		$this->register_wp_post_type( $this->slug, $args );
	} // end register
}
