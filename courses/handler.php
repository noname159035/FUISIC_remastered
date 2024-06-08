<?php

//TODO Добавить все проверки на ошибки подключения к базе

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
        case 'check_course_code':{
            // Получаем код доступа и пользователя из POST-запроса
            $accessCode = $_POST['accessCode'];
            $user = $_POST['user'];

            $query = "SELECT * FROM Courses WHERE referral_code = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('s', $accessCode);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Получаем данные первой строки результата
                $course = $result->fetch_assoc();
                $course_id = $course['id'];

                $query = "SELECT * FROM Course_students WHERE user_id  = ? AND course_id = ?";
                $stmt = $link->prepare($query);
                $stmt->bind_param('ss', $user, $course_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result-> num_rows > 0) {
                    // Пользователь уже присоединен к курсу
                    $response = array("success" => false, "message" => "Вы уже присоединены к этому курсу");
                }
                else{
                    // Код верный, пользователь еще не присоединен к курсу
                    $query = "INSERT INTO Course_students  (user_id, course_id) VALUES (?, ?)";
                    $stmt = $link->prepare($query);
                    $stmt->bind_param('ii', $user,$course_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $response = array("success" => true, "message" => "Код доступа верный", "course_id" => $course_id);
                }
            }
            else {
                // Если код доступа неверный, возвращаем сообщение об ошибке
                $response = array("success" => false, "message" => "Неверный код доступа");
            }
            break;
        }
        case 'add_course':{
            // Получаем название из POST-запроса
            $name = $_POST["name"];
            $user = $_POST["user"];

            $ref = $name.$user;

            $query = "SELECT * FROM Courses WHERE name = ? and user_id = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('ss', $name, $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if (mysqli_num_rows($result)==0) {

                $referral_code = md5($ref);

                $query = "INSERT INTO Courses  (name, user_id, referral_code) VALUES (?, ?, ?)";
                $stmt = $link->prepare($query);
                $stmt->bind_param('sis', $name, $user, $referral_code);
                if($stmt->execute()){
                    // Класс успешно создан
                    $created_id = $link->insert_id; // Получаем ID созданного курса
                    $response = array("success" => true, "message" => "Класс успешно создан", "course_id" => $created_id);
                }else{
                    // Произошла ошибка
                    $response = array("success" => false, "message" => $link->error);
                }

            } else {
                // Если название занято, возвращаем сообщение об ошибке
                $response = array("success" => false, "message" => "Данное название занято");
            }
            break;
        }
        case 'get_courses':{
            // Получаем название из POST-запроса
            $user = $_POST["user"];

            $query = "SELECT * FROM Courses WHERE user_id = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $user);
            $stmt->execute();
            $result = $stmt->get_result();

            $response = array();
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
            break;
        }
        case 'get_courses_for_students': {
            // Получаем user_id из POST-запроса
            $user_id = $_POST["user"];

            $query = "SELECT course_id FROM Course_students WHERE user_id = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $response = array();

            while ($course = $result->fetch_assoc()) {
                $course_id = $course['course_id']; // Используем значение course_id из массива

                $course_query = "SELECT * FROM Courses WHERE id = ?";
                $course_stmt = $link->prepare($course_query);
                $course_stmt->bind_param('i', $course_id);
                $course_stmt->execute();
                $course_result = $course_stmt->get_result();
                while ($row = $course_result->fetch_assoc()) {
                    $response[] = $row;
                }
            }
            break;
        }
        case 'get_all_data_for_teacher':{
            // Получаем название из POST-запроса
            $user = $_POST["user"];
            $course_id = $_POST["course_id"];

            $query = "SELECT * FROM Course_section WHERE course_id = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $response = array();
            while ($row = $result->fetch_assoc()) {
                $query = "SELECT * FROM Course_material WHERE course_section_id = ?";
                $stmt = $link->prepare($query);
                $stmt->bind_param('i', $row['id']);
                $stmt->execute();
                $result2 = $stmt->get_result();
                $row['data']=[];
                while ($data = $result2->fetch_assoc()) {
                    if($data['data_type_id'] == 4){

                        $query = "SELECT `Название` FROM `Тесты` WHERE `Код_теста` = ?";
                        $stmt = $link->prepare($query);
                        $stmt->bind_param('i', $data['data']);
                        $stmt->execute();
                        $result3 = $stmt->get_result();
                        $name = $result3->fetch_assoc();

                        $data['data'] = '/collections/test/'.$data['data'];
                        $data['name'] = $name['Название'];

                    }
                    if($data['data_type_id'] == 3){

                        $query = "SELECT `Название` FROM `Подборки` WHERE `Код подборки` = ?";
                        $stmt = $link->prepare($query);
                        $stmt->bind_param('i', $data['data']);
                        $stmt->execute();
                        $result3 = $stmt->get_result();
                        $name = $result3->fetch_assoc();

                        $data['data'] = '/collections/cards/'.$data['data'];
                        $data['name'] = $name['Название'];

                    }
                    $row['data'][]=$data;
                }
                $response[] = $row;
            }
            break;
        }
        case 'add_section':{
            // Получаем название из POST-запроса
            $user = $_POST["user"];
            $course_id = $_POST["course_id"];
            $section_name = $_POST["sectionName"];

            $query = "INSERT INTO Course_section  (name, course_id) VALUES (?,?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('si', $section_name, $course_id);
            if($stmt->execute()){
                // Раздел успешно создан
                $response = array("success" => true, "message" => "Раздел успешно создан", );
            }else{
                // Произошла ошибка
                $response = array("success" => false, "message" => $link->error);
            }

            break;
        }
        default:{

        }
    }

    // Отправляем ответ в формате JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
