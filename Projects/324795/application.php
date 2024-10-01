<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>

    <h2>User Registration</h2>
    <form action="" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>

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
        
        <input type="submit" value="Register">
    </form>
</body>
</html>

<?php
$servername = "sql305.infinityfree.com";
$username = "if0_34915534";
$password = "1gWufWlBNQvuvk7";
$dbname = "if0_34915534_CollectionApp";

$mysqli = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//Post information into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $createdAt = date('Y-m-d H:i:s');
    $securityQuestion = $_POST["security_question"];
    $securityAnswer = $_POST["security_answer"];

    $sql = "INSERT INTO User (Name, Email, Password, CreationDateTime, SecurityQuestion, SecurityAnswer) VALUES ('$name', '$email', '$password', '$createdAt', '$securityQuestion', '$securityAnswer')";
    $res = mysqli_query($mysqli, $sql);

    if ($res === TRUE) {
        echo "New record created successfully";
        header("Location: login.php");
        exit();
    } else {
        printf("Could not insert record: %s\n", mysqli_error($mysqli));
    }
}

mysqli_close($mysqli);
?>