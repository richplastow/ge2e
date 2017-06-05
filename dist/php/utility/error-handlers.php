<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////

//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


//// Switch off error reporting. The app hosting GE2E could re-enable it with:
//// error_reporting(E_ALL); ini_set('display_errors', 1);
$old_error_reporting_level = error_reporting(0);

//// Handle server-side script errors.
register_shutdown_function(
    function () {
        // global $action;
        // if (! $action) return; // no action was specified, so do nothing
        $errno   = E_CORE_ERROR;
        $errfile = "unknown-file";
        $errline = 0;
        $errstr  = "shutdown";
        $error = error_get_last();
        if (null !== $error) {
            $error2status = array(
                1     => 'error'   // E_ERROR
              , 2     => 'warning' // E_WARNING
              , 4     => 'parse'   // E_PARSE
              , 8     => 'notice'  // E_NOTICE
              , 16    => 'error'   // E_CORE_ERROR
              , 32    => 'warning' // E_CORE_WARNING
              , 64    => 'error'   // E_COMPILE_ERROR
              , 128   => 'warning' // E_COMPILE_WARNING
              , 256   => 'error'   // E_USER_ERROR
              , 512   => 'warning' // E_USER_WARNING
              , 1024  => 'notice'  // E_USER_NOTICE
              , 2048  => 'strict'  // E_STRICT
              , 4096  => 'error'   // E_RECOVERABLE_ERROR
              , 8192  => 'notice'  // E_DEPRECATED
              , 16384 => 'notice'  // E_USER_DEPRECATED
            );
            $errno   = $error2status[ $error["type"] ];
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr  = $error["message"];
        }
        panic($errno, $errfile, $errline, $errstr);
    }
);

//// Set the handler for user-defined errors.
$old_user_error_handler = set_error_handler(
    function ($errno, $errstr, $errfile, $errline) {
        if (E_USER_ERROR == $errno || E_ERROR == $errno)
            panic('error'  , $errfile, $errline, $errstr);
        if (E_USER_WARNING == $errno || E_WARNING == $errno)
            panic('warning', $errfile, $errline, $errstr);
        if (E_USER_NOTICE == $errno || E_NOTICE == $errno)
            panic('notice' , $errfile, $errline, $errstr);
        //@todo ignore notifications in production environment
        panic($errno, $errfile, $errline, $errstr); //@TODO can this be reached?
    }
);

//// Set the exception handler.
$old_exception_handler = set_exception_handler(
    function ($e) {
        panic( 'exception', $e->getFile(), $e->getLine(), $e->getMessage() );
    }
);


?>
