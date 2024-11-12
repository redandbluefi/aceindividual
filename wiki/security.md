## Security

### Defining Content Security Policy headers

Content Security Policy (CSP) is an added layer of security that helps to detect and mitigate certain types of attacks, including Cross-Site Scripting (XSS) and data injection attacks.

In Eternia, CSP headers are enabled by default with relatively strict settings. You can define project specific values in `inc/theme-settings.php` with an array key `csp_headers`. Values are given as a nested array:

```
'csp_headers' => array(
	'default-src' => array( "'self'" ),
	'script-src'  => array( "'self'", 'googletagmanager.com', 'cookiebot.eu' ),
);
 ```
This would be processed as a header value:
```
Content-Security-Policy: default-src 'self'; script-src 'self' googletagmanager.com cookiebot.eu
```

Values can be amended with filter hook `eternia_csp_headers`. For example, if you need to add a acf-option field for defining additional values, it's good to use the filter.

Example: Adding following callback to the filter:
```
add_filter(
	'eternia_csp_headers',
	function ( $csp_headers ) {
		$csp_headers['script-src'][] = 'my-other-domain.com';
		return $csp_headers;
	},
	99,
	1
);

```
This would result in the following header (amended with previous example's default values):
```
Content-Security-Policy: default-src 'self'; script-src 'self' googletagmanager.com cookiebot.eu my-other-domain.com
```

Read more about CSP:
https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/script-src