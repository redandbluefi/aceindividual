# Fixed terms for taxonomies

1. User can now create multiple fixed terms in different taxonomies.
2. First you create the custom taxonomies in taxonomies folder like before.
3. Then in theme-settings.php file you can use the fixed_terms spot and add multiple arrays of taxonomies if required.
4. An example below.

    ```
    'fixed_terms'        => array(
   	  'name_of_registerred_taxonomy' => array( //This is the slug of your taxonomy
				array(
					'slug'        => 'term_slug',
					'name'        => 'Term name', // needs translations
					'description' => 'Term description', // needs translations
				),
			),
			'my_other_custom_taxonomy'     => array( //This is the slug of your taxonomy
				array(
					'slug'        => 'term_slug',
					'name'        => 'Term name', // needs translations
					'description' => 'Term description', // needs translations
				),
			),
    ),
    ```
5. The 'lang' parameter is fi if you do not set it
6. If Polylang does not exist no lang is set. 
7. In Polylang settings you must set your taxonomy to be translatable if you wish to use this function.
8. If you do not need fixed terms you can comment out the register_fixed_terms_from_array call in hooks.php
9. The delete button in wp admin is removed automatically by function remove_delete_button_from_term_in_admin
