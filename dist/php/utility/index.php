<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////


//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


//// Handle server-side script errors.
require($path . '/utility/error-handlers.php');

//// Define the three JSON outputters: `ok()`, `fail()` and `panic()`.
require($path . '/utility/json-outputters.php');

//// Define functions for querying the database.
require($path . '/utility/db-mysql.php');

?>
