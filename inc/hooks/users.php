<?php
/**
 * User roles and caps related hooks
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Add caps to 'rnb_content_manager' role
 *
 * @return array The added capabilities for the 'rnb_content_manager' role.
 */
function rnb_content_manager_caps() {
	return array(
		'wpseo_manage_options'          => true,
		'wpseo_edit_advanced_metadata'  => true,
		'wpseo_bulk_edit'               => true,
		'wpseo_manage_redirects'        => true,
		'gravityforms_create_form'      => true,
		'gravityforms_delete_entries'   => true,
		'gravityforms_delete_forms'     => true,
		'gravityforms_edit_entries'     => true,
		'gravityforms_edit_entry_notes' => true,
		'gravityforms_edit_forms'       => true,
		'gravityforms_export_entries'   => true,
		'gravityforms_feed'             => true,
		'gravityforms_view_entries'     => true,
		'gravityforms_view_entry_notes' => true,
		'manage_options'                => true,
		'manage_links'                  => true,
		'customize'                     => true,
		'redirection'                   => true,
		'unfiltered_html'               => true,

		'edit_users'                    => true,
		'list_users'                    => true,
		'promote_users'                 => true,
		'create_users'                  => true,
		'add_users'                     => true,
		'delete_users'                  => true,
		'remove_users'                  => true,

		'delete_private_posts'          => true,
		'edit_private_posts'            => true,
		'read_private_posts'            => true,
		'delete_private_pages'          => true,
		'edit_private_pages'            => true,
		'read_private_pages'            => true,

		'copy_posts'                    => true,
	);
} // end rnb_content_manager_caps
