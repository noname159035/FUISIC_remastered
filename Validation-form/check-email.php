<?php
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);

$mysql = new mysqli('localhost', 'root', 'root' ,'Test_3');
if ($mysql->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysql->connect_error;
    exit();
}
$stmt = $mysql->prepare("SELECT * FROM Пользователи WHERE `e-mail` = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo 'exists';
} else {
    echo "$login";
}

$stmt->close();
$mysql->close();
?>