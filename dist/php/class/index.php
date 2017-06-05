<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////


//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


//// The (singleton) instance of this class is `$GE2E`, available globally.
require_once($path . '/class/GE2E.php');

//// Defines actions like 'ping' and 'trigger-user-error'.
require_once($path . '/class/GE2ECore.php');

//// A basic user implementation. Apps which host GE2E can opt to override it.
require_once($path . '/class/GE2EUser.php');


?>
