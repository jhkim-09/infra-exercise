<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>My Webserver</title>
</head>
<body>
    <h2>Database Manager</h2>

    <!-- 글자 입력 폼 -->
    <form method="post" action="">
        <input type="text" name="message" placeholder="Enter a message">
        <button type="submit" name="add">추가</button>
        <button type="submit" name="delete">제거</button>
        <button type="submit" name="view">전체확인</button>
    </form>

    <?php
    // 메시지 추가
    if (isset($_POST['add'])) {
        $message = $_POST['message'];

        if (!empty($message)) {
            $stmt = $conn->prepare("INSERT INTO messages (message) VALUES (?)");
            $stmt->bind_param("s", $message);
            $stmt->execute();
            echo "Message added: " . htmlspecialchars($message);
            $stmt->close();
        } else {
            echo "Please enter a message!";
        }
    }

    // 메시지 제거
    if (isset($_POST['delete'])) {
        $message = $_POST['message'];

        if (!empty($message)) {
            $stmt = $conn->prepare("DELETE FROM messages WHERE message = ?");
            $stmt->bind_param("s", $message);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Message deleted: " . htmlspecialchars($message);
            } else {
                echo "Message not found.";
            }
            $stmt->close();
        } else {
            echo "Please enter a message to delete!";
        }
    }

    // 메시지 확인 (전체 출력)
    if (isset($_POST['view'])) {
        $result = $conn->query("SELECT * FROM messages");

        if ($result->num_rows > 0) {
            echo "<h3>Messages:</h3>";
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($row['message']) . "</p>";
            }
        } else {
            echo "No messages found.";
        }
    }

    // 데이터베이스 연결 종료
    $conn->close();
    ?>
</body>
</html>

