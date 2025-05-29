<?php
// セッション開始
session_start();

// エラー表示（開発中のみ有効）
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB接続情報（本番用に書き換えてね）
$servername = "localhost";
$dbUsername = "root";      // 自分のDBユーザー名
$dbPassword = "";          // 通常XAMPPなら空
$dbname = "gitphp";        // 自分のDB名

// DB接続
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// フォームからの値を取得
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 空チェック（念のため）
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "ユーザー名とパスワードを入力してください。";
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQLインジェクション対策
    $stmt = $conn->prepare("SELECT id, username, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // ユーザーが存在するか確認
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // パスワード確認
        if (password_verify($password, $row['password'])) {
            // ログイン成功
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // リダイレクト
            header("location: index.php");
            exit;
        } else {
            echo "ユーザー名またはパスワードが違います。";
        }
    } else {
        echo "ユーザー名またはパスワードが違います。";
    }

    $stmt->close();
}

$conn->close();
?>
