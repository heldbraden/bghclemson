<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>
    <form action="" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        
        <input type="submit" value="Login">
    </form>

    <p>New user? <a href="application.php">Register here</a></p>
    <p>Forgot your password? <a href="reset.php">Reset it here</a></p>
</body>
</html>

<?php
//Start the session
session_start();

//Connecting to Database
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
    $email = $_POST["email"];
    $password = $_POST["password"];

    //Getting the user information
    $sql = "SELECT * FROM User WHERE Email='$email' AND Password='$password'";
    $res = mysqli_query($mysqli, $sql);

    $user = $res->fetch_assoc();
    $userID = $user['UserID'];
    $isLocked = $user['IsLocked'];
    
    //Checking for one user and if the account is locked
    if ($res->num_rows == 1 and $isLocked == FALSE) {

        //Updating current time of last login
        $currentDateTime = date('Y-m-d H:i:s');
        $updateLastLogin = "UPDATE User SET LastLoginDateTime='$currentDateTime' WHERE UserID='$userID'";
        mysqli_query($mysqli, $updateLastLogin);

        $loginCount = $user['LoginCount'];
        $isLocked = $user['IsLocked'];

        if ($loginCount == 3) {
            $isLocked = TRUE;
            echo "Locked Out! Reset Password";
        } else {
            //Updating login count
            $loginCount += 1;
            $updateLoginCount = "UPDATE User SET LoginCount='$loginCount' WHERE UserID='$userID'";
            mysqli_query($mysqli, $updateLoginCount);
            $isLocked = FALSE;
            
            //Updating session variables
            $_SESSION['user_id'] = $userID;
            $_SESSION['user_name'] = $user['Name'];
            $_SESSION['CreationDateTime'] = $user['CreationDateTime'];
            $_SESSION['LoginDateTime'] = $user['LastLoginDateTime'];
            $_SESSION['LoginCount'] = $user['LoginCount'] + 1;

            header("Location: collectApp.php");
            exit();
        }

    } else {
        echo "Invalid email or password";
    }
}

mysqli_close($mysqli);
?>