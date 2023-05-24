// Выводим список тестов
echo '<ul class="list-group list-group-flush list-group-testov">';
    while ($row_tests = mysqli_fetch_assoc($result_tests)) {
    echo '<li class="list-group-item d-flex justify-content-between align-items-center" data-test-id="' . $row_tests['Код подборки'] . '">';
        echo '<span class="test-title">' . $row_tests['Название'] . '</span>';
        echo '<div class="btn-group" role="group">';
            echo '<button class="btn btn-sm btn-primary ml-auto edit-test-btn" data-toggle="modal" data-target="#editCollectionModal" data-test-id="' . $row_tests['Код_Теста'] . '">Переименовать</button>'; // *Добавляем кнопку "Редактировать"
            echo '<a class="btn btn-sm btn-primary ml-auto" href="edit_test.php?test=' . $row_tests['Код_Теста'] . '">Редактировать</a>';
            echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="delete_test.php?id=' . $row_tests['Код_Теста'] . '">Удалить</a>';
            echo '</div>';
        echo '</li>';
    }

    while ($row_collections = mysqli_fetch_assoc($result_collections)) {
    echo '<li class="list-group-item d-flex justify-content-between align-items-center" data-collection-id="' . $row_collections['Код подборки'] . '">';
        echo '<span class="collection-title">' . $row_collections['Название'] . '</span>';
        echo '<div class="btn-group" role="group">';
            echo '<button class="btn btn-sm btn-primary ml-auto edit-collection-btn" data-toggle="modal" data-target="#editCollectionModal" data-collection-id="' . $row_collections['Код подборки'] . '">Переименовать</button>'; // *Добавляем кнопку "Редактировать"
            echo '<a class="btn btn-sm btn-primary ml-auto" href="edit_collection.php?podbor=' . $row_collections['Код подборки'] . '">Редактировать</a>';
            echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="delete_collection.php?id=' . $row_collections['Код подборки'] . '">Удалить</a>';
            echo '</div>';
        echo '</li>';
    }