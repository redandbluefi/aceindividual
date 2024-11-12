<?php
/**
 * Your Taxonomy taxonomy
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Registers the Your Taxonomy taxonomy.
 *
 * @param Array $post_types Optional. Post types in
 * which the taxonomy should be registered.
 */
class Your_Taxonomy extends Taxonomy {

	/**
	 * Taxonomy slug.
	 *
	 * @param array $post_types Optional. The taxonomy will be registered to these post types.
	 *
	 * @var string
	 */
	public function register( array $post_types = array() ) {
		// Taxonomy labels.
		$labels = array(
			'name'                  => translate__( 'Your Taxonomies', 'Taxonomy plural name', 'eternia' ),
			'singular_name'         => translate__( 'Your Taxonomy', 'Taxonomy singular name', 'eternia' ),
			'search_items'          => translate__( 'Search Your Taxonomies', '', 'eternia' ),
			'popular_items'         => translate__( 'Popular Your Taxonomies', '', 'eternia' ),
			'all_items'             => translate__( 'All Your Taxonomies', '', 'eternia' ),
			'parent_item'           => translate__( 'Parent Your Taxonomy', '', 'eternia' ),
			'parent_item_colon'     => translate__( 'Parent Your Taxonomy', '', 'eternia' ),
			'edit_item'             => translate__( 'Edit Your Taxonomy', '', 'eternia' ),
			'update_item'           => translate__( 'Update Your Taxonomy', '', 'eternia' ),
			'add_new_item'          => translate__( 'Add New Your Taxonomy', '', 'eternia' ),
			'new_item_name'         => translate__( 'New Your Taxonomy', '', 'eternia' ),
			'add_or_remove_items'   => translate__( 'Add or remove Your Taxonomies', '', 'eternia' ),
			'choose_from_most_used' => translate__( 'Choose from most used Taxonomies', '', 'eternia' ),
			'menu_name'             => translate__( 'Your Taxonomy', '', 'eternia' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => false,
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'show_tagcloud'     => false,
			'show_ui'           => true,
			'query_var'         => false,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug' => 'your-taxonomy',
			),
		);

		$this->register_wp_taxonomy( $this->slug, $post_types, $args );
	}
}
