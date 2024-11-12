# Sanitization

We have agreed to sanitize all user inputs to prevent attack vectors and unexpected behaviour. Sanitization can be conducted with the WordPress internal functions where applicable, or through utilisng our extended KSES constants.

Inputs should be sanitized before they are saved to the database, and also before they are outputted to the browser.

## Typical sanitization functions

When receiving user inputs, we should always sanitize them. Here are some of the most common sanitization functions in WordPress, but you can find exhaustive list of them in the [WordPress Codex](https://developer.wordpress.org/reference/functions/sanitize_text_field/).
- `sanitize_text_field`
- `sanitize_email`
- `sanitize_url`

## Typical escaping functions

When outputting user inputs, we should always escape them in order to remove dangerous or unnecessary syntax. Here are some of the most common escaping functions in WordPress, but you can find exhaustive list of them in the [WordPress Codex](https://developer.wordpress.org/reference/functions/esc_html/).
- `esc_html`
- `esc_attr`
- `esc_url`

## Customized KSES constants for escaping HTML

Eternia theme registers some KSES constants at `inc/includes/kses.php`. These should be used with `wp_kses` function to sanitize user inputs.

### Example use case

Here is an example of how to use our KSES functions with `wp_kses`:

```php
<?php 
// Input.
$ingress = '<p>Some text with <strong>strong</strong> and <br /> <em>italic</em>.</p>';

echo wp_kses( $ingress, KSES_ONLY_BR ); ?>

// Output: 'Some text with strong and <br /> italic.'
```
