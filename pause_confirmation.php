<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>休止確認パスワード</title>
</head>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px;}
    h1 { color: #333; }
    .btn { background-color: #9cf;}
</style>

<body>
    <h1>休止確認パスワード</h1>
    <form action="pause.php" method="post">
        <input type="password" name="password" require />
        <input type="submit" value="確定" class="btn" />
    </form>
</body>
</html>