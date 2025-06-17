<?php
// セッション開始
session_start(); 
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <!-- ↓セッション変数が空出ないかのチェック/':'は視認性向上のため -->
    <?php if (!empty($_SESSION['login_error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['login_error']; ?></p>
        <?php unset($_SESSION['login_error']); //一度表示したら削除 ?>
    <?php endif; ?>

    <!-- ログインフォーム -->
    <form action="login_check.php" method="post">
        <h1>ログイン</h1>
            <p>ユーザー名：<input type="text" name="name"></p>
            <p>パスワード：<input type="password" name="pass"></p>
            <p><input type="submit" value="ログイン"></p>
    </form>
</body>
</html>