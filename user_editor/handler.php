<?php

// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header('Location: /login/');
    exit();
}

require_once ('../db.php');

global $link;

$response = '';

if(isset($_POST['event'])){
    switch(($_POST['event'])){

        case 'get_all_users':{
            $user_id = $_COOKIE['user'];
            $query = "SELECT `Пользователи`.*, `Типы пользователей`.`Тип` FROM `Пользователи`
        INNER JOIN `Типы пользователей` ON `Пользователи`.`Тип пользователя`=`Типы пользователей`.`Код типа пользователя`
        WHERE `Пользователи`.`Код пользователя`!=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $response = array();
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
            break;
        }

        default:{}
    }

    // Отправляем ответ в формате JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}