<?php
//mysqli_report(MYSQLI_REPORT_OFF);

$mysql = new mysqli('localhost', 'p534029_admin', 'pI1aT7nO3h', 'p534029_Test_3');
if ($mysql->connect_errno) {
    die();
}
