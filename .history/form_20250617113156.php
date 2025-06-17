<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login_test.php'); 
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一言掲示板 - 投稿</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>💬 一言掲示板</h1>
    <p>ようこそ、<?php echo $_SESSION['user']['name']; ?>さん</p>
    <form action="post.php" method="post">
        <input type="hidden" name="name" value="<?php echo $_SESSION['user']['name']; ?>">
        <p>コメント：<br>
        <textarea name="comment" rows="4" cols="40" required></textarea></p>
        <p><button type="submit">投稿する</button></p>
    </form>
    <p><a href="view.php">▶ 投稿一覧を見る</a></p>
    <p><a href="logout_test.php">ログアウト</a></p>
</body>
</html>

