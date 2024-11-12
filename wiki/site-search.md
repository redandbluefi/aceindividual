# Site Search

## Single result
From single search result `result_id` parameter is passed to the search `result-item` -template. Template is located at `template-parts/search/result-item.php` 
In the template, the `result_id` is used to get the post type, title, date, excerpt, and permalink. The attachment image is also retrieved and displayed. If no image is found, placeholder image is used instead.

## rnb_get_first_term_object function
In `result-item` -template, the taxonomy of the result is retrieved using the helper function
`rnb_get_first_term_object` The function has two parameters `$post_id` and `$taxonomy_name`. Function can be used with custom taxonomies. 

The function will check if taxonomy exist (WP default or custom taxonomy). It also checks for Yoast primary term and returns it if found. Else it will return the first found term object. If the post has no terms, it returns an empty string.

 `rnb_get_first_term_object( $post_id, 'category' )`