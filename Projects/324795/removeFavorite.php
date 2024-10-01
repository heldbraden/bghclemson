<!DOCTYPE html>
<html>
<head>
    <title>Remove Favorite</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 250px;
            vertical-align: top;
            margin-right: 10px;
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    
    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit();
    }

    if(isset($_POST['FavoriteID'])) {
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
        $favorite_id = $_POST['FavoriteID'];
        //Delete item from the table
        $sql = "DELETE FROM FavoriteItems WHERE UserID = ? AND FavoriteID = ?";
        $stmt = mysqli_prepare($mysqli, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $user_id, $favorite_id);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        } else {
            echo "Error in preparing the statement: " . mysqli_error($mysqli);
        }
 
        mysqli_close($mysqli);
    } else {
        echo "No favorite item selected for removal.";
    }
    ?>
    <script>
        //Ajax request to handle the remove when clicked
        document.addEventListener("DOMContentLoaded", function() {
            let removeButtons = document.querySelectorAll('.removeFavoriteBtn');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    let favoriteId = this.getAttribute('data-favorite-id');
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', 'removeFavorite.php');
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                alert('Favorite item removed successfully.');
                            } else {
                                alert('Error removing favorite item.');
                            }
                        }
                    };
                    xhr.send('favorite_id=' + encodeURIComponent(favoriteId));
                });
            });
        });
    </script>
</body>
</html>



