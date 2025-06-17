<?php
// セッション開始
session_start();

$name = $_SESSION['user']['name'] ?? null;

// データベース接続（例）
$dsn = 'mysql:host=localhost;dbname=users;charset=utf8';
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    exit('DB接続に失敗しました：' . $e->getMessage());
}

$sql = "SELECT content, created_at FROM comment";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一言掲示板 - 投稿一覧</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>📜 投稿一覧</h1>
    <p><a href="form.php">← 投稿フォームへ戻る</a></p>
    <hr>
    <!-- データベースの値を表示させる -->
    <?php if ($results): ?>
        <?php foreach (array_reverse($results) as $row): ?>
            <div class='post'>
                <p>
                    <strong><?php echo htmlspecialchars($name); ?></strong>さん
                    <?php echo htmlspecialchars($row['created_at']); ?>
                </p>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>まだ投稿がありません。</p>
    <?php endif; ?>
</body>
</html>
