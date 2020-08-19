This library can be intergrated with Yii using instructions from 
[here:](http://www.yiiframework.com/doc-2.0/guide-tutorial-yii-integration.html#using-downloaded-libs)
 *Using Downloaded Libraries* section
 
 All requested functions are methods of class MMCFibo.
 Constructor of that class expects one parameter $db, which should be PDO connection to database.
 
 Fibo tree is kept in database in single table `fibo`
 This is the structure of that table:
 
```
 CREATE TABLE IF NOT EXISTS `fibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountNum` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL,
  `lchild` int(11) DEFAULT NULL,
  `rchild` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
```

Root node should be manualy inserted.

File run.php contains example of usage of MMCFibo class
