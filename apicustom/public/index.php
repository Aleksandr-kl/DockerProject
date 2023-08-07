<?php
global $CoreParams;
require_once('../config/config.php');

spl_autoload_register(function ($className) {
    $path = "../src/{$className}.php";

    if (file_exists($path)) {
        require_once $path;
    }

});

$database = new Database(
    $CoreParams['Database']['Host'],
    $CoreParams['Database']['Username'],
    $CoreParams['Database']['Password'],
    $CoreParams['Database']['Database']

);

$database->connect();
$query = new QueryBuilder();
//$query->select(["title", "text"])
//    ->from("news")
//    ->where(['id' => 16]);
//echo $query->getSql();
//$query->delete()
//    ->from("news")
//    ->where(['id'=>13]);
//$query->update(['title' => 'qwerty158', 'text' => 'ewq'])
//    ->from('news')
//    ->where(['id' => 9]);

//$query->insert(['title' => 'queryInsert3', 'text' => 'wertyblog3'])
//    ->from('news');
$query->select(["title"])
    ->from('news')
    ->inner_join('comments', 'news.id = comments.news_id');
echo $query->getSql();


$rows = $database->execute($query);
var_dump($rows);






//$pdo = new PDO("mysql:host=172.22.75.8;dbname=cms", "cms-user", "123456");
//$sth = $pdo->prepare("SELECT*FROM news WHERE id=:id");
//$sth->bindValue(
//    "id", 6
//);
//$sth->execute();
//$rows = $sth->fetchAll();
//var_dump($rows);
//$front_controller=new FrontController();
//$front_controller->run();


