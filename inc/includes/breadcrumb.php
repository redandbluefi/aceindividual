<?php
/**
 * Breadcrumb functionality
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Breadcrumb class
 *
 * Based on class in rnb wordpress-tools plugin with some additional modifications
 */
class Breadcrumb {
	/**
	 * The text for the home link.
	 *
	 * @var string $home_text The link text for the home link.
	 */
	private string $home_text;

	/**
	 * The main class for block wrapper.
	 *
	 * @var string $wrapper_block_class The class to add to the block wrapper.
	 */
	private string $wrapper_block_class;

	/**
	 * Additional classes for the blocks wrapper.
	 *
	 * @var string $additional_wrapper_classes Any additional classes you may want the block wrapper to have.
	 */
	private string $additional_wrapper_classes;

	/**
	 * Transient key.
	 *
	 * Transient is used to speed up page load, by caching the breadcrumb markup.
	 *
	 * @var string $transient_key The key to query the transient.
	 */
	private string $transient_key;

	/**
	 * Constructor
	 *
	 * @param array $args arguments for Breadcrumb object to be created
	 * - home_text: text for home link
	 * - wrapper_block_class: class name for wrapper block
	 * - additional_wrapper_classes: additional class name(s) for wrapper block.
	 */
	public function __construct( $args ) {
		$this->home_text                  = isset( $args['home_text'] ) ? $args['home_text'] : '';
		$this->wrapper_block_class        = isset( $args['wrapper_block_class'] ) ? $args['wrapper_block_class'] : 'rnb-breadcrumbs';
		$this->additional_wrapper_classes = isset( $args['additional_wrapper_classes'] ) && $args['additional_wrapper_classes'] ? ' ' . $args['additional_wrapper_classes'] : '';
		$this->transient_key              = $this->generate_transient_key();
	} // end __construct

	/**
	 * Generate transient key
	 * - singular items are identified by post id, e.g. 'rnb-br_single_123'
	 * - taxonomy terms are identified by term id, e.g. 'rnb-br_term_456'
	 * - other items use queried object name when available or a custom name + possible language identifier, e.g. 'rnb-br_post-type_news_en' or 'rnb-br_404_fi'
	 *
	 * @return string transient key OR empty string if transient key cannot be generated.
	 */
	public function generate_transient_key() {
		$prefix      = 'rnb-br';
		$key_strings = array( $prefix );

		$queried_object_name    = get_queried_object()->name ?? null;
		$queried_object_term_id = get_queried_object()->term_id ?? null;

		$add_lang_identifier = true;

		if ( is_singular() ) {
			$key_strings[]       = 'single';
			$key_strings[]       = get_the_ID();
			$add_lang_identifier = false;
		} elseif ( is_front_page() ) {
			$key_strings[] = 'front-page';
		} elseif ( is_search() ) {
			$key_strings[] = 'search';
		} elseif ( is_post_type_archive() && $queried_object_name ) {
			$key_strings[] = 'post-type';
			$key_strings[] = $queried_object_name;
		} elseif ( is_archive() && $queried_object_term_id ) {
			$key_strings[]       = 'term';
			$key_strings[]       = $queried_object_term_id;
			$add_lang_identifier = false;
		} elseif ( is_404() ) {
			$key_strings[] = '404';
		} else {
			return '';
		}

		if ( function_exists( 'pll_current_language' ) && $add_lang_identifier ) {
			$key_strings[] = \pll_current_language( 'slug' );
		}

		return implode( '_', $key_strings );
	} // end generate_transient_key

	/**
	 * Creates breadcrumb markup
	 * Saves breadcrumb markup to transient and uses it if available and in use.
	 *
	 * @return string breadcrumb markup
	 */
	public function create() {
		$list_class            = "{$this->wrapper_block_class}__list";
		$item_class            = "{$this->wrapper_block_class}__item";
		$breadcrumb_aria_label = esc_attr( translate__( 'Murupolku', 'Murupolun aria-label', 'eternia' ) );

		$queried = get_queried_object() ?? null;
		$open    = "<nav class='{$this->wrapper_block_class}{$this->additional_wrapper_classes} layout-grid' aria-label='{$breadcrumb_aria_label}'><ol class='{$list_class} alignwide'>";
		$close   = '</ol></nav>';

		$home_url = apply_filters( 'rnb_breadcrumb_home_url', get_home_url() );
		$home     = $this->get_single_item(
			array(
				'link'  => $home_url,
				'class' => "{$item_class} {$item_class}--home",
				'title' => $this->home_text,
			)
		);
		$items    = '';

		$recent = translate__( 'Ajankohtaista', '', 'eternia' );
		$search = translate__( 'Haku', '', 'eternia' );

		$recent = apply_filters( 'rnb_breadcrumb_recent_text', $recent );
		if ( is_category() ) {
			$link   = get_category_link( $queried->term_id );
			$items .= apply_filters(
				'rnb_breadcrumb_category',
				$this->get_single_item(
					array(
						'link'  => $link,
						'class' => $item_class,
						'title' => $queried->name,
					)
				)
			);
		} elseif ( is_archive() ) {
			$link   = get_post_type_archive_link( $queried->name );
			$items .= apply_filters(
				'rnb_breadcrumb_archive',
				$this->get_single_item(
					array(
						'link'  => $link,
						'class' => $item_class,
						'title' => $queried->label,
					)
				)
			);
		} elseif ( get_the_ID() === get_option( 'page_for_posts' ) ) {
			$link   = get_post_type_archive_link( $queried->name );
			$items .= apply_filters(
				'rnb_breadcrumb_home',
				$this->get_single_item(
					array(
						'link'  => $link,
						'class' => $item_class,
						'title' => $recent,
					)
				)
			);
		}

		if ( is_search() ) {
			$link   = '?s=';
			$items .= apply_filters(
				'rnb_breadcrumb_search',
				$this->get_single_item(
					array(
						'link'  => $link,
						'class' => $item_class,
						'title' => $search,
					)
				)
			);
		}

		if ( is_singular() ) {
			$ancestors     = get_post_ancestors( get_the_ID() );
			$post_type_obj = get_post_type_object( $queried->post_type );
			$has_archive   = $post_type_obj->has_archive;

			if ( $has_archive ) {
				$link   = get_post_type_archive_link( $queried->post_type );
				$items .= apply_filters(
					'rnb_breadcrumb_single_cpt_archive',
					$this->get_single_item(
						array(
							'link'  => $link,
							'class' => $item_class,
							'title' => $post_type_obj->label,
						)
					)
				);
			} elseif ( 'post' === $queried->post_type ) {
				$link   = get_post_type_archive_link( $queried->post_type );
				$items .= apply_filters(
					'rnb_breadcrumb_single_post_archive',
					$this->get_single_item(
						array(
							'link'  => $link,
							'class' => $item_class,
							'title' => $post_type_obj->label,
						)
					)
				);
			}

			if ( ! empty( $ancestors ) && apply_filters( 'rnb_breadcrumb_enable_ancestors', true ) ) {
				$ancestors = array_reverse( $ancestors );
				foreach ( $ancestors as $ancestor ) {
					$link  = get_permalink( $ancestor );
					$title = get_the_title( $ancestor );

					$items .= $this->get_single_item(
						array(
							'link'  => $link,
							'class' => $item_class,
							'title' => $title,
						)
					);
				}
			}

			$link  = get_permalink( get_the_ID() );
			$title = get_the_title( get_the_ID() );

			$items .= apply_filters(
				'rnb_breadcrumb_current',
				$this->get_single_item(
					array(
						'class'     => "{$item_class} {$item_class}--active",
						'title'     => $title,
						'is_active' => true,
					)
				)
			);
		}

		$open  = apply_filters( 'rnb_breadcrumb_open', $open );
		$close = apply_filters( 'rnb_breadcrumb_close', $close );

		$breadcrumb = apply_filters( 'rnb_breadcrumb', "$open $home $items $close" );

		// Set transient conditionally.
		if ( $this->transient_key ) {
			set_transient( $this->transient_key, $breadcrumb, apply_filters( 'rnb_breadcrumb_transient', 60 * 5 ) );
		}

		return $breadcrumb;
	} // end create

	/**
	 * Creates markup for single breadcrumb item.
	 *
	 * @param array $args arguments for single breadcrumb item
	 * - class: (string) class name for item
	 * - link: (string) url link for item
	 * - title: (string) title for item
	 * - is_active: (boolean) whether item is active (current page) or not.
	 * @return string Single breadcrumb item markup.
	 */
	public function get_single_item( $args = array() ) {
		$class     = isset( $args['class'] ) ? $args['class'] : false;
		$link      = isset( $args['link'] ) ? $args['link'] : false;
		$title     = isset( $args['title'] ) ? $args['title'] : false;
		$is_active = isset( $args['is_active'] ) ? $args['is_active'] : false;

		$item_markup = '<li ';

		if ( $class ) {
			$item_markup .= 'class="' . esc_attr( $class ) . '"';
		}

		if ( $is_active ) {
			$item_markup .= " aria-current='page'";
		}
		$item_markup .= '>';

		if ( $link ) {
			$item_markup .= '<a href="' . esc_url( $link ) . '"';
			$item_markup .= '>';
		}

		if ( $title ) {
			$item_markup .= esc_html( $title );
		}

		if ( $link ) {
			$item_markup .= '</a>';
		}
		$item_markup .= '</li>';

		return $item_markup;
	} // end get_single_item

	/**
	 * Gets cached breadcrumb markup
	 *
	 * @return string|boolean cached breadcrumb markup OR false if the transient does not exist, does not have a value, or has expired.
	 */
	public function get_cached() {
		return get_transient( $this->transient_key );
	} // end get_cached

	/**
	 * Returns printable breadcrumb markup
	 *
	 * @return string breadcrumb markup
	 */
	public function print() {
		if ( apply_filters( 'rnb_breadcrumb_use_cache', true ) && ! empty( $this->transient_key ) ) {
			$cached = $this->get_cached();
		} else {
			$cached = false;
		}

		if ( ! $cached ) {
			$breadcrumb = $this->create();
		} else {
			$breadcrumb = $cached;
		}

		return $breadcrumb;
	} // end print
}
