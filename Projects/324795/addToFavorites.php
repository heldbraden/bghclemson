<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

$servername = "sql305.infinityfree.com";
$username = "if0_34915534";
$password = "1gWufWlBNQvuvk7";
$dbname = "if0_34915534_CollectionApp";

$mysqli = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_SESSION['user_id'];
    $song = $_POST['song'];
    $addAt = date('Y-m-d H:i:s');
    $artistName = $_POST['artist'];

    //Inserting the item into favorites
    $sql = "INSERT INTO FavoriteItems (UserID, DateTimeAdded, Song, ArtistName) VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($mysqli, $sql);

    mysqli_stmt_bind_param($stmt, "isss", $user_id, $addAt, $song, $artistName);
    if (mysqli_stmt_execute($stmt)) {
        echo "Added to favorites successfully!";
    } else {
        echo "Failed to add to favorites.";
    }

    $stmt->close();
}

mysqli_close($mysqli);
?>