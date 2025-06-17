<?php
session_start();

// データベース接続（例）
$dsn = 'mysql:host=localhost;dbname=users;charset=utf8';
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    exit('DB接続に失敗しました：' . $e->getMessage());
}

// フォームから送信された値を取得
$username = $_POST['name'];
$pass = $_POST['pass'];

// ユーザーを検索
$sql = 'SELECT * FROM user WHERE username = :username';
$stmt = $pdo->prepare($sql);
$stmt->execute([':username' => $username]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// 照合処理（パスワードは平文）
if ($result && $pass === $result['password']) {
    // セッションに保存
    $_SESSION['user'] = [
        'id' => $result['id'],
        'name' => $result['username']
    ];
    // エラーフラグを消す（次にページを読み込んだ時にもそのまま表示されてしまうから）
    unset($_SESSION['login_error']);

    // リダイレクト
    header('Location: form.php');
    exit;
} else {
    $_SESSION['login_error'] = 'ユーザー名またはパスワードが違います。';
    header('Location: login_test.php');
    exit;
}
?>
