<?php

require_once ('db.php');

global $link;

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$Id = $_GET['id'];

$query = "SELECT Название FROM Подборки WHERE `код подборки` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$idName = $result->fetch_array(MYSQLI_ASSOC)['Название'];

$query = "SELECT * FROM `Карточка` WHERE Подборка = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $Id);
$stmt->execute();
$result = $stmt->get_result();

// Код для вывода карточек
if (isset($Id) && $Id != 0) {

// Создание массива всех карточек
    $cardsArr = [];
    while ($row = $result->fetch_assoc()) {
        $card = [
            'formula' => $row['Формула'],
            'description' => $row['Описание'],
            'explanation'=> $row['Пояснение'],
            'id'=> $idName
        ];
        $cardsArr[] = $card;
    }

    $json = json_encode($cardsArr);

    echo $json;
}else {
    // Вывод ошибки, если id не задан или равен 0
    echo 'Error: id не задан или равен 0';
}