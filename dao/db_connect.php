<?php
function school_db_connect(&$link1) {
    $link1 = mysqli_connect('10.64.144.5', '23jya02', '23jya02', '23jya02');
    if (!mysqli_set_charset($link1, "utf8")) {
        printf("Error loading character set utf8: %s\n", mysqli_error($link1));
        exit();
    }
    if (mysqli_connect_errno()) {
        die("データベースに接続できません:" . mysqli_connect_error() . "\n");
    }
}

function db_connect() {
    $host = '10.64.144.5'; // ホスト名
    $dbname = '23jya02'; // データベース名
    $username = '23jya02'; // ユーザー名
    $password = '23jya02'; // パスワード
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    } catch (PDOException $e) {
        exit("データベース接続エラー: " . $e->getMessage());
    }
}
?>
