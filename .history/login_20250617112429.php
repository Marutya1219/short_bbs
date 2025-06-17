<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit;
}

require_once 'util/Database.php';
$DB = new users();
$pdo = $DB->getConnection();

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['ID'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];

    try {
        // パスワード再確認チェック
        if ($password !== $password_check) {
            $error_message = "パスワードが一致しません。再確認してください。";
        } else {
            // IDの重複チェック
            $stmt = $pdo->prepare("SELECT * FROM management WHERE ID = ?");
            $stmt->execute([$id]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $error_message = "このIDは既に登録されています。";
            } else {
                // 新規ユーザー登録
                $stmt = $pdo->prepare("INSERT INTO management (ID, password) VALUES (?, ?)");
                $stmt->execute([$id, $password]);

                $success_message = "登録成功しました。";
            }
        }
    } catch (Exception $e) {
        $error_message = "登録中にエラーが発生しました: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/auth.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>ユーザー管理</h1>
        </header>
        <main>
            <?php include_once 'util/sidebar.php'; ?>
            <section class="content">
                <!-- 登録フォーム -->
                <form action="#" method="post">
                    <label for="ID">ID</label><br>
                    <input type="text" name="ID" id="ID" required><br>

                    <label for="password">パスワード</label><br>
                    <input type="password" name="password" id="password" required><br>


                    <button type="submit">登録</button><br>

                    <!-- メッセージの表示 -->
                </form>
            </section>
        </main>
    </div>
</body>

</html>
