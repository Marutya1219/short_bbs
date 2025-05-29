<?php
    session_start();
    $_SESSION = array(); // セッションの値を初期化
    session_destroy(); //セッションを破棄
?>

