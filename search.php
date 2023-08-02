<?php
$link = new mysqli('localhost', 'username', 'password', 'database');
$query = "SELECT * FROM collections WHERE name LIKE '%{$_GET['query']}%' OR chapter LIKE '%{$_GET['query']}%'";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="collection">';
    echo '<p id="name_of_collection">'. $row['name']. '</p>';
    echo '<p id="name_of_chapter">'. $row['chapter']. '</p>';
    echo '</div>';
}

mysqli_close($link);
?>
