<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////


//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );


class Frog {

    public static $actions = [
        'fresh-frog' => [
            'title' => 'Fresh Frog'
          , 'notes' => 'Delete all Frog instances and recreate the Frog table'
          , 'method'=> 'GET'
          , 'level' => 'developer'
          , 'class' => 'Frog'
          , 'func'  => 'fresh'
          , 'args'  => []
        ]
      , 'add-frog' => [
            'title' => 'Add Frog'
          , 'notes' => 'Create a new Frog instance'
          , 'method'=> 'GET'
          , 'level' => 'registered'
          , 'class' => 'Frog'
          , 'func'  => 'add'
          , 'args'  => [ //  optn’l unique  test      title
                'name'  => [ false, true,  '/@TODO/', 'The Frog’s name' ]
              , 'color' => [ true,  false, '/@TODO/', 'Its most distinctive color' ]
            ]
        ]
      , 'read-frog' => [
            'title' => 'Read Frog'
          , 'notes' => 'Retrieve the properties of some Frog instances'
          , 'method'=> 'GET'
          , 'level' => 'anonymous'
          , 'class' => 'Frog'
          , 'func'  => 'read'
          , 'args'  => [ // optional   test        title
                'frog_ids' => [ true, '[]natural', 'Primary Key' ]
            ]
        ]
    ];

    public static function fresh ($args, $GE2E) {
        $rows = db_fresh('frog', array(
            'frog_id' => 'INT AUTO_INCREMENT PRIMARY KEY'
          , 'name'    => 'CHAR(20)'
          , 'color'   => 'CHAR(8)'
        ));
        ok('Frog fresh');
    }
    public static function add ($args, $GE2E) {
        $keyvals = array(
            'name'  => $args['name']
          , 'color' => $args['color']
        );
        $id = db_add('frog', $keyvals);
        ok($id);
    }
    public static function read ($args, $GE2E) {
        $rows = db_read('frog', $args);
        ok($rows);
    }

}

//// Add all the Frog actions to GE2E’s `$sctions` array.
foreach (Frog::$actions as $action_name => $action) {
    $GE2E->actions[$action_name] = $action;
}

?>
