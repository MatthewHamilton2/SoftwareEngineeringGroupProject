<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <Section id="registerSection">
    <form action="register.php" method="post">
        <input type = "text" name="username" placeholder="Username"><br>
        <input type = "password" name="password" placeholder="Password"><br>
        <input type = "text" name="email" placeholder="Email"><br>
        <input type = "submit" name = "submit" value = "Register">
    </form>
        <?php
        include("connect.php");
        if(isset($_POST['submit'])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];


        if(empty($username)){
            echo"Please enter a Username"."<br>";
        }
        else if(empty($password)){
            echo"Please enter a Password"."<br>";
        }
        else if(empty($email)){
            echo"Please enter an Email Address"."<br>";
        }
        else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try{
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";
        mysqli_query($conn, $sql);
        }
        catch(mysqli_sql_exception){
            $sql = "SELECT username FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                echo"That Username is already taken";
            }
            else{
                echo"That Email Address is already taken";
            }
        }
        mysqli_close($conn);
        }
        }
        ?>
    <h1>Already have an account? Then log in <a href="login.php">here</a></h1>
    </Section>
    <Section id="registerExplanationSection">
    <h1>Welcome to CollabNexus!</h1>
    <h1>...</h1>
    </Section>
</body>
</html>
