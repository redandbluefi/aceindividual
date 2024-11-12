# ACF options pages

1. User can now create multiple options sub pages easily adding the required data to theme settings file in array format
2. The array takes three values page_title, menu_title and parent_slug
3. The parent_slug is not required as without it all of the sub option pages go below the one option page that has allready been created.
4. If you need additional options top level pages you can add one using acf_add_options_sub_page() function. The menu_slug determines which sub pages are below it.

   ```
   acf_add_options_page(array(
     'page_title'    => 'Add name here',
     'menu_title'    => 'Add name here',
     'menu_slug'     => 'this-is-the-slug-that-is-needed',
   ));
   ```

5. theme-settings.php file contains theme_options_pages array where you can add more usefull parts like the one below

   ```
   [
     'page_title'    => 'Add a name here', // This name is visible in page heading
     'menu_title'    => 'Add a name here', // This name is visible in the menu
     'parent_slug'   => 'theme-general-settings', // This name ensures that the page is added to the correct menu
   ],
   ```

6. If polylang is installed user must select language from the top menu to edit the right options page. If no language is selected an error message is shown.

7. In order to retrieve information from the theme settings, there is a get_default_lang_option() helper function created in the helpers.php file. With this function, field information is retrieved, either according to the language of the site or, if Polylang is active, according to the pll_current_language.

`$lang_pid = get_default_lang_option()`
`$heading = get_field( '404_heading', $lang_pid ) ?? '';`
