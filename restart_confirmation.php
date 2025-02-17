<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>再開確認パスワード</title>
</head>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px;}
    h1 { color: #69be86; }
    .btn { background-color: #9cf;}
</style>

<body>
    <h1>再開確認パスワード</h1>
    <form action="index.php" method="post">
        <input type="password" name="password" require />
        <input type="submit" value="確定" class="btn" />
    </form>
</body>
</html>