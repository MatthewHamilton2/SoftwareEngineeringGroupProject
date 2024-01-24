<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <Section id="loginSection">
    <form action="login.php" method="post">
        <input type = "text" name="username" placeholder="Enter Username or Email"><br>
        <input type = "password" name="password" placeholder="Enter Password"><br>
        <input type = "submit" name = "submit" value = "Log in">
    </form>
        <?php
        include("connect.php");
        if(isset($_POST['submit'])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(empty($username)){
            echo"Please enter a Username or Email Address"."<br>";
        }
        else if(empty($password)){
            echo"Please enter a Password"."<br>";
        }
        else {

        $sql = "SELECT password FROM users WHERE (username = '$username' OR email = '$username')";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            if(password_verify($password, mysqli_fetch_assoc($result)["password"])){
                echo"login successful";
            }
            else{
                echo"That Username or Password was incorrect";
            }
        }
        else{
            echo"That Username or Password was incorrect";
        }
        mysqli_close($conn);
        }
        }
        ?>
    <h1>Dont have an account? Then register <a href="register.php">here</a></h1>
    </Section>
    <Section id="loginExplanationSection">
    <h1>Welcome to CollabNexus!</h1>
    <h1>...</h1>
    </Section>
</body>
</html>
