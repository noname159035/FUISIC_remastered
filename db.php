<?php
//mysqli_report(MYSQLI_REPORT_OFF);

$link = new mysqli('localhost', 'p534029_admin', 'pI1aT7nO3h', 'p534029_Test_3');
if ($link->connect_errno) {
    die();
}
