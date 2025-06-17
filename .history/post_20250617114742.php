<?php
// セッション開始
session_start();

// form.phpから送信されたセッションの値を取得
$user_id = $_SESSION['id'] ?? null;
$comment = htmlspecialchars($_POST['comment'] ?? '');

// データベース接続（例）
$dsn = 'mysql:host=localhost;dbname=users;charset=utf8';
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    exit('DB接続に失敗しました：' . $e->getMessage());
}

// テーブルに登録するINSERT INTO文
$sql = "INSERT INTO comment (content) VALUES (:content)";
$stmt = $pdo->prepare($sql); // 値が空のままsql文をセット
// 挿入する値を配列に格納
$params = [
    ':content' => $comment,
];
// 挿入する値が入った変数をexecuteにセットしてsql文を実行
$stmt->execute($params);

// コメントが空の場合、リダイレクトして処理を中止
if (trim($comment) === '') {
    header("Location: form.php");
    exit;
}

header("Location: view.php");
exit;
?>
