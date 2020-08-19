<?php

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

$db = new PDO('mysql:host=localhost;dbname=mmc', 'root', 'root');

/*
$db->exec("delete from fibo where id>11");
$db->exec("update fibo set lchild=null where lchild>11");
$db->exec("update fibo set rchild=null where rchild>11");
$db->exec("ALTER TABLE `fibo` AUTO_INCREMENT =12");
*/
//$db->exec("truncate table fibo");
//$db->exec("insert into fibo(email) values('test@abp.com')");

$mmc = new Abp\MMC\Fibo\MMCFibo($db);
//$mmc->addNode(100);
/* OLD TEST */
/*
$mmc->addNodes("test@abp.com", 1, [1], false, "goran.terzic@gmail.com");
$mmc->addNodes("goran.terzic@gmail.com", 1, [2], false, "goran.terzic1@gmail.com");
$mmc->addNodes("test@abp.com", 3, [3, 4, 5], false, "goran.terzic2@gmail.com");
*/
//var_dump($mmc->getNode(2));
 

/* TEST FOR CLUSTER */
//$nodes = $mmc->addNodes('gerrydekens@gmail.com', 3, [1001, 1011, 1021], false, 'yuvraj@abp.com');

//$nodes = $mmc->addNodes('goran.terzic@gmail.com', 3, [200, 201, 202], true, 'goran.terzic2@gmail.com');
//var_dump($nodes);
print('<pre>');
print_r($mmc->getNodes('yuvraj@abp.com'));
