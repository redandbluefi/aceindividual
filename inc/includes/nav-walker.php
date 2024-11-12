<?php
/**
 * Nav walker for menus.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Custom Nav Walker class:
 * - sub menu toggles as buttons
 * - parent item link as first item in sub menu with h2 tag
 */
class Nav_Walker extends \Walker_Nav_Menu {
	/**
	 * Icon type for menu toggle
	 *
	 * @var string slug of icon to be used as menu toggle
	 */
	private $icon_type;

	/**
	 * Constructor
	 *
	 * @param string $icon_type slug of icon to be used as menu toggle.
	 */
	public function __construct( $icon_type = '' ) {
		$this->icon_type = $icon_type;
	} // end __construct

	/**
	 * Creates markup for starting element
	 *
	 * @param string $output The menu item's starting HTML output.
	 * @param object $item Menu item data object.
	 * @param int    $depth Depth of menu item.
	 * @param object $args An object of wp_nav_menu() arguments.
	 * @param int    $id ID of the current item.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$title            = $item->title;
		$permalink        = $item->url;
		$link_target      = $item->target ? $item->target : '_self';
		$link_target_attr = '_blank' === $link_target ? "target='$link_target' rel='noopener nofollow'" : "target='$link_target'";
		$id               = $item->ID;
		$item_classes     = $item->classes ?? array();
		$item_classes[]   = 'menu-item__level-' . $depth + 1;
		$class_list       = implode( ' ', $item_classes );
		$output          .= "<li id='$id' class='$class_list'>";

		$item_has_submenu = $item->classes && in_array( 'menu-item-has-children', $item->classes, true ) ? true : false;

		if ( $item_has_submenu ) {
			$output .= '<button aria-haspopup="true" aria-expanded="false" class="sub-menu__toggle"><span class="sub-menu__toggle-text">' . esc_html( $title ) . '</span>' . inline_svg(
				'chevron-down.svg',
				array(
					'wrapper' => 'i',
					'class'   => 'sub-menu__toggle-icon',
				),
				false
			) . '</button>';
		} else {
			$output .= '<a ' . $link_target_attr . ' href="' . esc_url( $permalink ) . '">' . esc_html( $title ) . '</a>';
		}

		$sub_menu_parent_link = $item_has_submenu && 0 === $depth ? "<a class='sub-menu__parent-item' $link_target_attr href='" . esc_url( $permalink ) . "'>" . esc_html( $title ) . '</a>' : '';
		$field_container      = $item_has_submenu && $depth < 2 ? "<div class='sub-menu__container'><div class='sub-menu__content-wrapper'><div class='sub-menu__content'>" : '';

		$output .= $field_container . $sub_menu_parent_link;
	} // end start_el

	/**
	 * Creates markup for ending element
	 *
	 * @param string $output The menu item's ending HTML output.
	 * @param object $item Menu item data object.
	 * @param int    $depth Depth of menu item.
	 * @param object $args An object of wp_nav_menu() arguments.
	 * @param int    $id ID of the current item.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$id = $item->ID;

		if ( isset( $item->classes ) && in_array( 'menu-item-has-children', $item->classes, true ) && 0 === $depth ) {

			$output .= '</div></div></div></li>';
		}
	} // end end_el
}
