<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////

//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );




//// CONNECT

$dbs = array();
function db_connect ($db_tag) {
    global $GE2E_CONFIG, $dbs;
    if (! $db_tag) $db_tag = 'default';

    //// Reuse a database-reference if it’s already been created.
    if ( isset($dbs[$db_tag]) ) return $dbs[$db_tag];

    //// Otherwise, get the database connection config...
    if (! property_exists($GE2E_CONFIG->database, $db_tag) ) trigger_error(
        "No such db_tag '$db_tag' in GE2E_CONFIG", E_USER_ERROR);
    $db_config = $GE2E_CONFIG->database->$db_tag;

    //// ...and connect to it.
    $db = new mysqli(
        $db_config->host
      , $db_config->username
      , $db_config->password
      , $db_config->dbname
      , $db_config->port
    );
    if ($db->connect_errno) trigger_error(
        "Cannot connect to '$db_tag' ($db->connect_errno)", E_USER_ERROR);

    $dbs[$db_tag] = $db;
    return $db;
}




//// FRESH

function db_fresh ($table_name, $args, $db_tag=0) {
    global $dbs;
    $db = isset($dbs[$db_tag]) ? $dbs[$db_tag] : db_connect($db_tag);

    //// Build the column-definition SQL.
    $columns = array();
    foreach ($args as $column_name => $column_type)
        $columns[] = "$column_name $column_type";
    $columns = '    ' . implode("\n  , ", $columns);

    //// Remove the table if it already existed.
    $result = $db->query("DROP TABLE IF EXISTS $table_name");
    if (! $result) trigger_error(
        "Cannot drop '$table_name': ($db->errno) $db->error", E_USER_ERROR);

    //// Recreate the table with the specified columns.
    $result = $db->query("CREATE TABLE $table_name(\n$columns\n)");
    if (! $result) trigger_error(
        "Cannot recreate '$table_name': ($db->errno) $db->error", E_USER_ERROR);
}




//// ADD

function db_add ($table_name, $args, $db_tag=0) {
    global $dbs;
    $db = isset($dbs[$db_tag]) ? $dbs[$db_tag] : db_connect($db_tag);

    $keys   = array();
    $values = array();
    foreach ($args as $key => $value) {
        $keys[]   = $key;
        $values[] = $value;
    }
    $keys   = implode(',', $keys);
    $values = "'" . implode("','", $values) . "'"; //@TODO better prep of values

    $result = $db->query("INSERT INTO $table_name($keys) VALUES ($values)");
    if (! $result) trigger_error(
        "Cannot add to '$table_name': ($db->errno) $db->error", E_USER_ERROR);

    return $db->insert_id; // the primary key of the inserted item
}




//// READ

function db_read ($table_name, $args, $db_tag=0) {
    global $dbs;
    $db = isset($dbs[$db_tag]) ? $dbs[$db_tag] : db_connect($db_tag);

    $result = $db->query("SELECT * FROM $table_name");
    if (! $result) trigger_error(
        "Cannot read '$table_name': ($db->errno) $db->error", E_USER_ERROR);

    $rows = array();
    while ( $row = $result->fetch_row() ) {
        $rows[] = $row;
    }
    print_r($rows);
    return $rows;
}



/*
//// RESET

function db_fresh_all () {
    global $db, $db_error;
    if (null === $db) db_connect();

    $entity_columns =
          'entity_id INT AUTO_INCREMENT PRIMARY KEY' // entity id
      . ', creator_id INT' // id of the user which created this entity
      . ', created  TIMESTAMP DEFAULT CURRENT_TIMESTAMP' // eg '2017-05-02 18:07:53'
      . ', modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP' // eg '2017-05-04 11:56:24'
      . ', location_id INT' // every entity has a location id
    ;

    $location_columns =
          'location_id INT AUTO_INCREMENT PRIMARY KEY' // location id
    ;

    $user_columns =
          'user_id INT AUTO_INCREMENT PRIMARY KEY' // user id
      . ', created  TIMESTAMP DEFAULT CURRENT_TIMESTAMP' // eg '2017-05-02 18:07:53'
      . ', modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP' // eg '2017-05-04 11:56:24'
      . ', username VARCHAR(40)'  //@TODO make unique
      . ', password VARCHAR(255)' //
      . ', email VARCHAR(255)'    //@TODO make unique
    ;

    $permission_columns = // http://www.mysqltutorial.org/mysql-primary-key/
          'user_id INT NOT NULL'
      . ', entity_id INT NOT NULL'
      . ', PRIMARY KEY(user_id,entity_id)' // permission id
      . ', created  TIMESTAMP DEFAULT CURRENT_TIMESTAMP' // eg '2017-05-02 18:07:53'
      . ', modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP' // eg '2017-05-04 11:56:24'
      . ', permission_code INT' // describes the type of permission
      . ', FOREIGN KEY(user_id) REFERENCES users(user_id)'
      . ', FOREIGN KEY(entity_id) REFERENCES entities(entity_id)'
    ;

    $subscription_columns =
          'subscription_id INT AUTO_INCREMENT PRIMARY KEY' // subscription id
      . ', created  TIMESTAMP DEFAULT CURRENT_TIMESTAMP' // eg '2017-05-02 18:07:53'
      . ', modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP' // eg '2017-05-04 11:56:24'
      . ', user_id INT'
      . ', location_id INT'
      . ', subscription_code INT' // describes the type of subscription
    ;

    if (! $db->query("DROP TABLE IF EXISTS permissions, entities, locations, subscriptions, users") ||
        ! $db->query("CREATE TABLE entities($entity_columns)") ||
        ! $db->query("CREATE TABLE locations($location_columns)") ||
        ! $db->query("CREATE TABLE users($user_columns)") ||
        ! $db->query("CREATE TABLE permissions($permission_columns)") ||
        ! $db->query("CREATE TABLE subscriptions($subscription_columns)")
    ) {
        return $db_error = "FAILED creating tables: ($db->errno) $db->error";
    }
}



*/
?>
