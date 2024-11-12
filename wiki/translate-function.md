# Translate\_\_() function

Eternia has a custom function named translate\_\_(). This function and its helpers works in cooperation with the Polylang plugin helping to gather the translatable strings for Polylang. With this function the translator can translate all the strings available under the Polylang Translations menu in WordPress admin.

## The files

- Function translate\_\_() is located in inc/includes/polylang-wrapper.php
- Finding and registering the strings is done in inc/includes/polylang-register-strings.php

## The function

This is the function call you can see in polylang-wrapper.php

`translate__( $string_to_translate = '', $context = '', $group = '' )`

### One parameter usage

How to use the translate\_\_() function in daily development work? The function has three parameters and only the translatable string is required. Remember to escape the output. Here is an example for basic usage.

`<p><?php echo esc_html( translate__( 'Here is the translatable string' ) ); ?></p>`

### With $name parameter

Here is an example for a use case where you might want to give the translator more info about the translatable string. Use the second parameter for this.

`<p><?php echo esc_html( translate__( 'Here is the translatable string', 'String inside the footer element' ) ); ?></p>`

### Give me everything

Of course you can use all three parameters. You can use the $group parameter for grouping translatable strings inside Polylang. Why would you use the $group parameter? Here is an example. When you add translate\_\_() function to every single translatable string inside the theme there could be hundreds of strings to translate. This could be a little too much for the translator who is only interested in the string on the front-end side, not some backend custom post type names.

In this case you could use grouping for separating the front-end and lets say custom post types. Here are a couple of examples. First a custom post type registering the labels.

```
$generated_labels = array(
	'menu_name'          => translate__( 'Videos', 'Menu name', 'Custom post type' ),
	'name'               => translate__( 'Video', 'Name', 'Custom post type' ),
	'singular_name'      => translate__( 'Video', 'Singular name', 'Custom post type' ),
)
```

Second example with some string in navigation

`<p><?php echo esc_html( translate__( 'Close menu', 'Close button text', 'Customer name' ) ); ?></p>`

Now if you look at the Translations found under Polylang you can see two groups named Custom post type and Customer name. The translator can now focus purely on the strings found under group Customer name and later on if needed translate the rest of the strings from another group.

Of course you can skip the second parameter but its strongly advised to come up with some informative text to help the translator to locate the text from the site. Here is an example without the second parameter.

`<p><?php echo esc_html( translate__( 'Close menu', null, 'Customer name' ) ); ?></p> // Try to use all three parameters.`

### Special cases

If you don't use the third parameter it's generated automatically for you. Function uses site title for the default group name. Inside your project you may choose not to use the group parameter unless there is a special need for it. This way all strings get the same group name without any typos or slight variations in group name.

You can of course skip the second parameter as seen in the example above but try to come up with something meaningful for helping the translator. Second parameter is shown right next to the translatable string in Polylang Translations.

### A known bug

Polylang only registers and shows the first occurance of the string. So if you register the two examples below only the first one is shown in Translations.

```
<p><?php echo esc_html( translate__( 'Close menu', 'Navigation close button', 'Customer name' ) ); ?></p>
<p><?php echo esc_html( translate__( 'Close menu', 'Sidenavigation close button', 'Different group name' ) ); ?></p>
```

### Add translations to db

Add to GitHub deployment action also.

Non-multisite / single site:

```sh
wp eternia set strings to translate
```

Multisite:

```sh
wp site list --field=url | xargs -n1 -I % wp --url=% eternia set strings to translate
```
