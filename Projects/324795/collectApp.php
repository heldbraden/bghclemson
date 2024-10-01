<?php
    $servername = "sql305.infinityfree.com";
    $username = "if0_34915534";
    $password = "1gWufWlBNQvuvk7";
    $dbname = "if0_34915534_CollectionApp";
    
    $mysqli = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    } else {
        mysqli_close($mysqli);
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Song Collection</title>
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
        header("Location: login.php");
        exit();
    }

    //Master list of information for user
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $creation = $_SESSION['CreationDateTime'];
    $lastLogin = $_SESSION['LoginDateTime'];
    $numLogin = $_SESSION['LoginCount'];

    echo "Welcome, $user_name! This is your collectApp page.<br>";
    echo "Date Created: $creation<br>";
    echo "Last Login: $lastLogin<br>";
    echo "Number of Logins: $numLogin<br>";

    ?>

    <?php
    //Showing the search
    if (!isset($_GET['search']) || isset($_GET['search']) && !isset($_GET['page'])) {
        ?>
        <h1>iTunes Search</h1>
        <a href="showFavorites.php">Favorites</a>
        <a href="login.php">Sign Out</a>
        <form action="" method="GET">
            <label for="search">Search Term:</label>
            <input type="text" id="search" name="search">
            <select name="mediaType">
                <option value="music">Music</option>
                <option value="movie">Movies</option>
                <option value="podcast">Podcasts</option>
                <option value="tvShow">TV Shows</option>
                <option value="audiobook">Audio Books</option>
                <option value="all">All</option>
            </select>
            <button type="submit">Search</button>
        </form>
        <?php
    }
    ?>

    <div id="resultsContainer">
        <?php
        //Displaying the results of search
        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $mediaType = isset($_GET['mediaType']) ? $_GET['mediaType'] : 'music';
            
            //Keeping results to 15 per page
            $resultsPerPage = 15;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startIndex = ($currentPage - 1) * $resultsPerPage;

            //Connect to itunes api
            $url = "https://itunes.apple.com/search?term=" . urlencode($searchTerm) . "&media=" . urlencode($mediaType) . "&limit=$resultsPerPage&offset=$startIndex";

            $response = file_get_contents($url);

            if ($response !== false) {
                //Decoding the information recieved from the api and outputing to user
                $data = json_decode($response, true);

                if (isset($data['results']) && count($data['results']) > 0) {
                    foreach ($data['results'] as $result) {
                        $artworkUrl = $result['artworkUrl100'];
                        $artistName = $result['artistName'];
                        $songName = $result['trackName'];

                        echo "<div class='card'>";
                        echo "<img src='$artworkUrl' alt='Artwork'>";
                        echo "<p>Artist: $artistName</p>";
                        echo "<p>Song: $songName</p>";
                        echo "<button class='favoriteBtn' onclick='addToFavorites(\"$user_id\", \"$artistName\", \"$songName\")'>Favorite</button>";
                        echo "</div>";
                    }
                } else {
                    echo "No results found.";
                }
            } else {
                echo "Failed to fetch data from iTunes API";
            }
        } else {
            echo "Please enter a search term.";
        }
        ?>
    </div>

    <?php
    //Load more button
    if (isset($_GET['search']) && $currentPage * $resultsPerPage < 45) {
        ?>
        <div style='text-align: center; margin-top: 20px;' id="loadMoreBtnContainer">
            <button id="loadMore">Load More</button>
        </div>
        <?php
    }
    ?>

  <script>
        //Getting the search information and loading more
        let currentPage = <?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>;
        document.getElementById("loadMore").addEventListener("click", function() {
            currentPage++;
            let searchTerm = "<?php echo isset($_GET['search']) ? urlencode($_GET['search']) : ''; ?>";
            let mediaType = "<?php echo isset($_GET['mediaType']) ? urlencode($_GET['mediaType']) : 'music'; ?>";
            let url = `?search=${searchTerm}&mediaType=${mediaType}&page=${currentPage}`;
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("resultsContainer").innerHTML += data;
                    let loadMoreBtnContainer = document.getElementById("loadMoreBtnContainer");
                    if (currentPage * 15 >= 45) {
                        loadMoreBtnContainer.innerHTML = '';
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        //Adding to favorites
        async function addToFavorites(user_id, artist, song) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "addToFavorites.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            let data = `user_id=${user_id}&song=${encodeURIComponent(song)}&artist=${encodeURIComponent(artist)}`;

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                        alert("Added to favorites!");
                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                }
            };

            xhr.send(data);
        }
    </script>

</body>
</html>
