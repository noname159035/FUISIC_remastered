<?php

$dbc = mysqli_connect('localhost', 'root', 'root', 'Test_3');
$user_id = mysqli_real_escape_string($dbc, $_COOKIE['user']);
$current_password = mysqli_real_escape_string($dbc, $_POST['password']);

$stmt = mysqli_prepare($dbc, "SELECT * FROM Пользователи WHERE `Код пользователя` = ? AND `Password` = ?");
mysqli_stmt_bind_param($stmt, 'ss', $user_id, $current_password);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) == 0) {
    echo "$current_password";
} else {
    echo 'OK';
}

mysqli_stmt_close($stmt);
mysqli_close($dbc);

?>
