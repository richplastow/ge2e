<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////

//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


$GE2E = null;

//// In a closure (to avoid polluting global scope), load utilities and classes.
call_user_func(function() {
    global $GE2E_CONFIG, $GE2E;

    //// Make `require()` load relative to this file, not the original PHP file.
    $path = dirname(__FILE__);

    require($path . '/utility/index.php');
    require($path . '/class/index.php');

});


/*

//// Allow the front end to be served from anywhere, eg GitHub pages or a CDN.
header("Access-Control-Allow-Origin: *");
*/

?>
