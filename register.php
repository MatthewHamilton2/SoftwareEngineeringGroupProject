<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styling.css">
</head>
<body class="unset">
    <header>
		<div class="logo">
		  <img src="logo.png" alt="Collab Nexus Logo">
		  <h1>Task Troopers: Register</h1>
		</div>
	</header>
	<section>
	<div class="form">
		<form action="register.php" method="post">
			<h1>Enter username</h1>
			<input type = "text" name="username" placeholder="Username"><br>
			<h1>Enter password</h1>
			<input type = "password" name="password" placeholder="Password"><br>
			<h1>Enter email</h1>
			<input type = "text" name="email" placeholder="Email"><br>
			<br>
			<input type = "submit" name = "submit" value = "Register">
		</form>
			<?php
			include("connect.php");
			if(isset($_POST['submit'])){
			$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
			$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
			$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

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
			$sql = "INSERT INTO users (username, password, email, type) VALUES ('$username', '$hashedPassword', '$email', 'educator')";
			mysqli_query($conn, $sql);
			$_SESSION["username"] = $username;
			echo "<script> location.href='index.php'; </script>";
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
		<h1 class="alternative">Already have an account? Then log in <a href="login.php">here</a></h1>
	</div>
    </Section>
</body>
</html>
