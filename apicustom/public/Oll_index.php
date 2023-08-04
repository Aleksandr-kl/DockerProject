<?php

date_default_timezone_set('Europe/Kiev');
$pdo = new PDO("mysql:host=172.22.75.8;dbname=cms", "cms-user", "123456");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $text = $_POST['text'];
    $title = $_POST['title'];
    $date = date("Y-m-d H:i:s");
    $pdo->query("INSERT INTO news(title,text,date) VALUES('{$title}' ,'{$text}','{$date}')");

};

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"public/index.php

          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post" action="">
    <div>Title</div>
    <div>
        <input type="text" name="title"/>
    </div>
    <div>Text</div>
    <div>
        <textarea name="text"></textarea>
    </div>
    <div>
        <button type="submit">Add</button>
    </div>
</form>
<?php
$page= $_GET['page'] ?? 1; //перевіряємо чи існує прараметер,якщо існує тоді ложимо в змінну значення page. А якщо не існу тоді тоді номер сторінки 1
$limit=5;
$offset = ($page - 1) * $limit;

?>
<div>
    <h2>News list</h2>
    <table>
        <?php
        //$sth = $pdo->query("SELECT * FROM news");
        $count = $pdo->query("SELECT COUNT(id) as count FROM news");
        $total = $count->fetchColumn();
        $totalPages = ceil($total/ $limit);
        $sth=$pdo->query("SELECT * FROM news LIMIT $limit OFFSET $offset");

        while ($row = $sth->fetch()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['date'] ?></td>
            </tr>

        <?php endwhile; ?>
    </table>

    <div>
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <a href="?page=<?= $i ?>"><?= $i; ?></a>
        <?php endfor;?>
    </div>

</div>
</body>
</html>

