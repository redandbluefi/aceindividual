# PHP Formatting and Lintter

Eternia base theme includes "squizlabs/php_codesniffer" lintter for php. Lintter config is located in file: `phpcs.xml`

Lintter is using Eternia php Coding Standars which are based on Wordpress Coding Standards:
https://developer.wordpress.org/coding-standards/wordpress-coding-standards/

## Using linter

- Currently linter is not part of automatic build processes (commented out from gulp setup, because theme's code base is not yet formatted to match standard)
- You can use linter manually by:
  1. `composer install` to install linter packages
  2. use command `./vendor/bin/phpcs [my-file-name.php]` to lint check a file in repo

## Formatting code

### With VS Code

- You can automate code formatting process by installing plugin Vscode plugin "PHP Sniffer & Beautifier (Samuel Hilson)"
- Plugin reads `phpcs.xml` config file and provides matching formatting, making it much easier to meet theme's php coding standars.
- Plugin will do most formatting changes automatically, but it won't perform any destructive changes; so you might need to take care of some parts manually, e.g. adding file comments or renaming variables
- How to install plugin:
  1. Make sure linter is installed and working (see "Using linter" above)
  2. Install "PHP Sniffer & Beautifier (Samuel Hilson)" plugin
  3. Set "PHP Sniffer & Beautifier (Samuel Hilson)" as your default formatter for php files. Easy way to do this, is by:
    disabling your current php formmater (e.g. PHP Intelephense) 
    --> then try running auto-format `shift + option + F` command on a php-file 
    --> vscode will prompt about missing php formatter and provide link to correct setting
  4. Restart VS Code

- If everything work fine, you should be able to format php files with autoformatting (`shift + option + F`) and see possible lintter issues in "Problems" tab next to terminal window.
- Some cases you might need to adjust plugin settings (PHP Sniffer & Beautifier --> Extension settings)
```
Phpsab: Executable Path CBF: ./vendor/bin/phpcbf
Phpsab: Executable Path CS: ./vendor/bin/phpcs
```