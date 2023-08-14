<?php
global $CoreParams;

use App\Core\Database\Database;
use App\Core\Database\QueryBuilder;
use App\Core\FrontController;

require_once('../config/config.php');

spl_autoload_register(function ($className) {
    $newClassName=str_replace('\\', '/',$className);
    if(stripos($newClassName,'App/')===0){
        $newClassName=substr($newClassName,4);
    }
    $path = "../src/{$newClassName}.php";

    if (file_exists($path)) {
        require_once $path;
    }

});
$core=\App\Core\Core::GetInstance();
$core->Init();
$core->Run();
$core->Done();


//
//\App\Core\StaticCore::Init();
//\App\Core\StaticCore::Run();
//\App\Core\StaticCore::Done();





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
//$query->select(["title"])
//    ->from('news')
//    ->inner_join('comments', 'news.id = comments.news_id');
//echo $query->getSql();
//$query->insert(['title' => 'queryInsert4', 'text' => 'wertyblog4'])->from('news');
//echo $query->getSql();

//$rows = $database->execute($query);
//var_dump($rows);

$record=new \App\Models\News();
$record->title="title1";
$record->text="text1";
$record->date="2023-08-11 18:15:31";
$record->save();

//$front_controller=new FrontController();
//$front_controller->run();




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


