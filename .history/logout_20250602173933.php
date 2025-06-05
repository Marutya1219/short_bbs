<?php
    session_start();

    // セッションの値を初期化
    $_SESSION = array(); 

    // セッションを破棄
    session_destroy(); 

    // ログイン画面に遷移
    header("Location: short_bbs/login.php");
?>

