<?php
$servername = "localhost"; // 데이터베이스 서버 주소
$username = "root"; // MariaDB 사용자 이름
$password = "123"; // MariaDB 비밀번호
$dbname = "mydatabase"; // 사용할 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

