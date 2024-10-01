<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="" method="post">
    <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        
        <label for="security_question">Security Question:</label><br>
        <select id="security_question" name="security_question">
            <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
            <option value="What was the name of your first pet?">What was the name of your first pet?</option>
            <option value="Where were you born?">Where were you born?</option>
            <option value="What is your favorite book?">What is your favorite book?</option>
            <option value="What is the name of your best friend?">What is the name of your best friend?</option>
        </select><br>
        
        <label for="security_answer">Answer:</label><br>
        <input type="text" id="security_answer" name="security_answer"><br>

        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password"><br>
        
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>

<?php
session_start();

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
    $security_question = $_POST["security_question"];
    $security_answer = $_POST["security_answer"];
    $newPassword = $_POST["new_password"];

    //Getting the security question and answer user inputted on the application
    $sql = "SELECT * FROM User WHERE Email='$email' AND SecurityQuestion='$security_question' AND SecurityAnswer='$security_answer'";
    $res = mysqli_query($mysqli, $sql);

    $isLocked = FALSE;
    $loginCount = 0;

    if ($res->num_rows == 1) {

        //Updating the password
        $updatePassword = "UPDATE User SET Password='$newPassword' WHERE Email='$email' AND SecurityQuestion='$security_question' AND SecurityAnswer='$security_answer'";
        mysqli_query($mysqli, $updatePassword);

        //Resetting the locked and login count
        $updateLock = "UPDATE User SET IsLocked='$isLocked' WHERE Email='$email' AND SecurityQuestion='$security_question' AND SecurityAnswer='$security_answer'";
        mysqli_query($mysqli, $updateLock);

        $updateCount = "UPDATE User SET LoginCount='$loginCount' WHERE Email='$email' AND SecurityQuestion='$security_question' AND SecurityAnswer='$security_answer'";
        mysqli_query($mysqli, $updateCount);

        header("Location: login.php");
        exit();
    } else {
        echo "Invalid security question or answer";
    }
}

mysqli_close($mysqli);
?>