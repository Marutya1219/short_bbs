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
    <?php
    $filename = 'comments.txt';
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        foreach (array_reverse($lines) as $line) {
            [$time, $name, $comment] = explode("\t", $line);
            echo "<div class='post'>";
            echo "<p><strong>$name</strong> さん ($time)</p>";
            echo "<p>" . nl2br($comment) . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>まだ投稿がありません。</p>";
    }
    ?>
</body>
</html>
