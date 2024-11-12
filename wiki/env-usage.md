# Using Dotenv

For example API credentials should not be added directly to project theme code for security reasons. One way to avoid this is add credentials to .env file and read them from there.

## Local environment (Local WP)

1. Run `composer install`. After that this plugin should be installed: https://github.com/vlucas/phpdotenv
2. Add these modifications to wp-config.php (which can be found from app/public folder). Remember to change theme folder name according to your project.

```
// Load Composer libraries
require_once dirname(__DIR__) . '/public/wp-content/themes/eternia/vendor/autoload.php';

if ( file_exists( dirname(__DIR__) . '/public/wp-content/themes/eternia/.env' ) ) {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable( dirname( dirname(__DIR__) . '/public/wp-content/themes/eternia/.env' ) );
    $dotenv->load();
}
```
3. Define constants: Add these also to wp-config.php

```
define( 'MY_API_USERNAME', getenv('MY_API_USERNAME') );
define( 'MY_API_SECRET', getenv('MY_API_SECRET') );
```
4. Add .env file in the theme root (if it does not exist already) and add values there

```
# My API
MY_API_USERNAME = "username"
MY_API_SECRET = "secret"
```
5. Create secure note (for example "Project Name local .env") to LastPass and add .env file content there for other project developers. **The .env file should never be added to GitHub.**

## Seravo

Seravo documentation: https://seravo.com/docs/environment/environment-variables/#using-dotenv

1. Add .env file to `data/wordpress` folder 
2. Define constants in wp-config.php same way than in local environment. Other changes to wp-config.php should not be necessary. You can find wp-config.php from `htdocs` folder.
