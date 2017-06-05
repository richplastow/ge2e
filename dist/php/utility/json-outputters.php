<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////


//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


////@TODO explain.
$has_ended = false;


//// `ok()` signifies a successful API call.
function ok($value, $string_is_escaped=false) {
    global $has_ended;
    if (! $has_ended) {
        if (! $string_is_escaped && is_string($value) )
            $value = '"' . str_replace('"', '\"', $value) . '"';
        else if (! is_scalar($value) ) // eg an array or object
            $value = json_encode($value);
        echo '{"status":"ok", "value":' . $value . '}';
    }
    $has_ended = true;
    exit(0);
}


//// `fail()` signifies a problem with the client request, or a server problem
//// which has been anticipated and handled.
function fail($value) { // `$value` is the reason for the failure
    global $has_ended;
    if (! $has_ended) {
        echo '{"status":"fail", "value":"' . str_replace('"','\"',$value) . '"}';
    }
    $has_ended = true;
    exit(0);
}


//// `panic()` signifies an unexpected server warning or error, which could
//// not be converted to a `fail()` call.
function panic($status, $path, $line, $reason) {
    global $has_ended;
    if (! $has_ended) {
        echo '{"status":"' . $status . '", "value":"'
          . str_replace( '"', '\"', basename($path) . ':' . $line . ': ' . $reason )
          . '"}'
        ;
    }
    //@todo email admin
    $has_ended = true;
    exit(1);
}

?>
