# Logs for debugging

Helper function for debugging: [logging.php](https://github.com/redandbluefi/eternia/blob/main/inc/includes/logging.php)

Function `write_log()` gets message/variable content passed as parameter. Function writes the content to separate log file with timestamp.

For example: 

- `write_log( $variable );`
- `write_log( 'Data has been saved.' );` 
- `write_log( $query->posts );`

Default name for the log file is `eternia__debug.log`. The name can be changed in `theme-settings.php` (`log_file`). Also the maximum length of output (`log_output_maxlength`) can be modified there. The limitation is necessary so that the buffer max size is not exceeded.

This feature is ment only for temporary log writing so production code should not include permanently `write_log()` function calls.

## Local environment

The log file will be created in `/app/public/` OR `/app/public/wp-admin/` folder. Location depends on the file where the `write_log()` function has been called.

## Production server

WP_DEBUG has to be set as true (remember to change the setting back to false after debugging). This setting can be modified in `htdocs/wp-config` file.

On production server the log file can be found in `/data/log/` folder.

### Specific production log

If you want to add spesific production log file define in constants.php:

```
// Production log file.
$eternia_log_args = array(
	'log_file'       => 'eternia.log',
	'production_log' => true,
);
define( 'ETERNIA_PRODUCTION_LOG', $eternia_log_args );
```

You can then add logs like this and they will only be written to the log file on the production server:

`write_log( 'Your log content', ETERNIA_PRODUCTION_LOG );`


