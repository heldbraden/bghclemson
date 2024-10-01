<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

echo "$user_name favorites page.";
?>

<?php
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

$user_id = $_SESSION['user_id'];

//Getting the users favorite items from the database
$sql = "SELECT * FROM FavoriteItems WHERE UserID = ?";
$stmt = mysqli_prepare($mysqli, $sql);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

echo "<h1>Your Favorite Items</h1>";
echo "<div class='favoritesContainer'>";

//Displaying results
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='card'>";
    echo "<h3 class='card-title'>" . $row['Song'] . "</h3>";
    echo "<p class='card-text'>Artist: " . $row['ArtistName'] . "</p>";
    echo "<p class='card-text'>Date Added: " . $row['DateTimeAdded'] . "</p>";
    echo "<form method='post' action='removeFavorite.php'>";
    echo "<input type='hidden' name='FavoriteID' value='" . $row['FavoriteID'] . "'>";
    echo "<button type='submit' class='removeFavoriteBtn'>Remove</button>";
    echo "</form>";
    echo "</div>";
}

echo "</div>";

echo "<a href='collectApp.php'>Go back to Collect App</a>";

mysqli_stmt_close($stmt);

mysqli_close($mysqli);
?>