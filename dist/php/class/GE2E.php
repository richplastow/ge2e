<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////


//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


//// The (singleton) instance of this class is `$GE2E`, available globally.
class GE2E {

    public $actions = array();

    public function runAction (
        $get         // usually from `$_GET`
      , $method_name // usually from `$_SERVER['REQUEST_METHOD']`
    ) {

        //// Simulate a slow server, for testing and performance-profiling.
        if ( isset($get['millisleep']) ) usleep($get['millisleep'] * 1000);

        //// Actions are specified in the query string, eg:
        //// https://example.com/endpoint/index.php?action=do-your-thing
        $action_name = isset($get['action']) ? $get['action'] : null;

        //// Reject obviously incorrect requests.
        if (! $action_name) trigger_error(
            "No 'action' specified. Try 'action=show-actions'", E_USER_WARNING);
        if (! isset($this->actions[$action_name]) ) trigger_error(
            "Action not recognised. Try 'action=show-actions'", E_USER_WARNING);

        //// Get info about the action.
        // $action = ;

        //// Reject requests which do not conform to the action’s signature.
        extract($this->actions[$action_name], EXTR_PREFIX_ALL, 'action');
        //@TODO more checks

        if ($action_method !== $method_name) trigger_error(
            "Must use '$action_method' for '$action_name'", E_USER_WARNING);

        //// Run the action if specified.
        call_user_func(
            array($action_class, $action_func) // eg `array('Frog','read')`
          , $get
          , $this
        );

    }
}

$GE2E = new GE2E();

?>
