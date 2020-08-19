<?php
/**
 * Created by PhpStorm.
 * User: imyuvii
 * Date: 12/02/16
 * Time: 3:53 PM
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = '';

    // base directory for the namespace prefix
    $base_dir = __DIR__ .'/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }

});
error_reporting(0);
$config = require('../protected/config/db.php');
$userName = $config['username'];
$password = $config['password'];
$connectionString = $config['connectionString'];
$db = new PDO($connectionString, $userName, $password);
$mmc = new Abp\MMC\Fibo\MMCFibo($db);

$json = file_get_contents('php://input');
$obj = json_decode($json);
switch($obj->action){
    case 'add':
        $nodes = $mmc->addNodes(trim($obj->parent),$obj->count,$obj->accounts,$obj->cluster,$obj->email,$obj->table_name);
        if($nodes){
            echo json_encode([
                "result" => true,
                "data" => $nodes,
                "parent" => $obj->parent,
                "user" => $obj->email,
                "accounts" => $obj->accounts,
                "count" => $obj->count
            ]);
        } else {
            echo json_encode([
                "result" => false,
                "error" => "Something wrong with the API",
                "parent" => $obj->parent,
                "user" => $obj->email,
                "accounts" => $obj->accounts,
                "count" => $obj->count
            ]);
        }
        break;
    default:
}


/* TEST FOR CLUSTER */
//$nodes = $mmc->addNodes('test@abp.com', 5, [100, 101, 102, 103, 104], false, 'goran.terzic@gmail.com');
//
//$nodes = $mmc->addNodes('goran.terzic@gmail.com', 3, [200, 201, 202], true, 'goran.terzic2@gmail.com');
//var_dump($nodes);
//var_dump($mmc->getNodes('goran.terzic@gmail.com'));
