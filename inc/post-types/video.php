<?php
/**
 * Registers Video post type for the theme.
 *
 * @package eternia
 **/

namespace Eternia;

/**
 * Registers the Your Post Type VIDEO.
 */
class Video extends Post_Type {

	/**
	 * Register the custom post type.
	 */
	public function register() {

		// Modify all the i18ized strings here.
		$generated_labels = array(
			'menu_name'          => translate__( 'Videot', '', 'eternia' ),
			'name'               => translate__( 'Video', '', 'eternia' ),
			'singular_name'      => translate__( 'Video', '', 'eternia' ),
			'name_admin_bar'     => translate__( 'Video', '', 'eternia' ),
			'add_new'            => translate__( 'Lisää uusi', '', 'eternia' ),
			'add_new_item'       => translate__( 'Lisää uusi Video', '', 'eternia' ),
			'new_item'           => translate__( 'Uusi Video', '', 'eternia' ),
			'edit_item'          => translate__( 'Muokkaa Videota', '', 'eternia' ),
			'view_item'          => translate__( 'Näytä Video', '', 'eternia' ),
			'all_items'          => translate__( 'Kaikki videot', '', 'eternia' ),
			'search_items'       => translate__( 'Etsi videoita', '', 'eternia' ),
			'parent_item_colon'  => translate__( 'Vanhemmat videot:', '', 'eternia' ),
			'not_found'          => translate__( 'videoita ei löytynyt.', '', 'eternia' ),
			'not_found_in_trash' => translate__( 'videoita ei löytynyt roskakorista.', '', 'eternia' ),
		);

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type.
		$args = array(
			'labels'              => $generated_labels,
			'description'         => '',
			'menu_icon'           => 'dashicons-paperclip',
			'public'              => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'rewrite'             => array(
				'with_front' => false,
				'slug'       => 'video',
			),
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
			'taxonomies'          => array( 'Video_category' ),
		);

		$this->register_wp_post_type( $this->slug, $args );
	} // end register
}
