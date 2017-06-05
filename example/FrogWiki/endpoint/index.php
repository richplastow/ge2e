<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////

//// All includes should run `defined('GE2E_ENDPOINT') or exit(...)`.
define('GE2E_ENDPOINT', true);


//// LOAD

//// Load configuration for the PHP distribution of the GE2E framework.
require_once('../../../CONFIG_GE2E.php');

//// Load and initialise the PHP distribution of the GE2E framework.
require_once('../../../dist/php/boot.php');

//// Ge2E has switched off error-reporting - we can re-enable it here.
error_reporting(E_ALL); ini_set('display_errors', 1);

//// Load classes which (among other things) define FrogWiki’s `$actions`.
require_once('class/index.php');


//// PROCESS THE REQUEST

$GE2E->runAction(
    $_GET                      // $get
  , $_SERVER['REQUEST_METHOD'] // $method_name
);

?>
