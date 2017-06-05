<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////


//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


//// Defines actions like 'ping' and 'trigger-user-error'.
class GE2ECore {

    public static $actions = [


        //// ANONYMOUS
        //// These actions are callable by all clients (no $_SESSION is needed).

        'ping' => [
            'title' => 'Ping'
          , 'notes' => 'Returns the value \'pong\' in a standard JSON object'
          , 'method'=> 'GET'
          , 'level' => 'anonymous'
          , 'class' => 'GE2ECore'
          , 'func'  => 'ping'
          , 'args'  => []
        ]
      , 'show-actions' => [
            'title' => 'Show Actions'
          , 'notes' => 'Shows a list of valid API actions'
          , 'method'=> 'GET'
          , 'level' => 'anonymous'
          , 'class' => 'GE2ECore'
          , 'func'  => 'showActions'
          , 'args'  => []
        ]


        //// REGISTERED
        //// Any signed in user can call these actions.
        ////@TODO


        //// ADMINISTRATOR
        //// These actions for performing database administration and the like.
        //// These can only be called by a signed in developer or administrator.
        ////@TODO


        //// DEVELOPER
        //// These actions can simulate errors, warnings and exceptions.
        //// These can only be called:
        //// 1. When the app is in development mode
        //// 2. Or when a developer is signed in

      , 'trigger-exception' => [
            'title' => 'Trigger Exception'
          , 'notes' => 'Simulates an uncaught exception'
          , 'method'=> 'GET'
          , 'level' => 'developer'
          , 'class' => 'GE2ECore'
          , 'func'  => 'triggerException'
          , 'args'  => []
        ]
      , 'trigger-user-warning' => [
            'title' => 'Trigger User Warning'
          , 'notes' => 'Simulates an E_USER_WARNING'
          , 'method'=> 'GET'
          , 'level' => 'developer'
          , 'class' => 'GE2ECore'
          , 'func'  => 'triggerUserWarning'
          , 'args'  => []
        ]
      , 'trigger-user-error' => [
            'title' => 'Trigger User Error'
          , 'notes' => 'Simulates an E_USER_ERROR'
          , 'method'=> 'GET'
          , 'level' => 'developer'
          , 'class' => 'GE2ECore'
          , 'func'  => 'triggerUserError'
          , 'args'  => []
        ]
      , 'trigger-php-warning' => [
            'title' => 'Trigger PHP Warning'
          , 'notes' => 'Simulates an E_WARNING'
          , 'method'=> 'GET'
          , 'level' => 'developer'
          , 'class' => 'GE2ECore'
          , 'func'  => 'triggerPHPWarning'
          , 'args'  => []
        ]
      , 'trigger-php-error' => [
            'title' => 'Trigger PHP Error'
          , 'notes' => 'Simulates an E_ERROR'
          , 'method'=> 'GET'
          , 'level' => 'developer'
          , 'class' => 'GE2ECore'
          , 'func'  => 'triggerPHPError'
          , 'args'  => []
        ]
    ];




    //// ANONYMOUS

    public static function ping ($args, $GE2E) {
        ok('pong');
    }

    public static function showActions ($args, $GE2E) {
        global $GE2E;
        $out = array();
        foreach ($GE2E->actions as $key => $val) {
            $out[] = '"<a href=\'?action=' . $key . '\'>'
                    . $val['title'] . '</a>": "'
                    . $val['method'] . ' ' . $val['notes'] . '"';
        }
        ok("{\n  " . implode($out, ",\n  ") . "\n}", true);
    }


    //// DEVELOPER

    public static function triggerException ($args, $GE2E) {
        throw new Exception('Triggered an "uncaught exception"');
    }
    public static function triggerUserWarning ($args, $GE2E) {
        trigger_error('Triggered a "user warning"', E_USER_WARNING);
    }
    public static function triggerUserError ($args, $GE2E) {
        trigger_error('Triggered a "user error"', E_USER_ERROR);
    }
    public static function triggerPHPWarning ($args, $GE2E) {
        $foo = 1;
        each($foo);
    }
    public static function triggerPHPError ($args, $GE2E) {
        no_such_function();
    }

}

//// Add all the GE2ECore actions to GE2E’s `$sctions` array.
foreach (GE2ECore::$actions as $action_name => $action) {
    $GE2E->actions[$action_name] = $action;
}

?>
