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
<body class = "unset">
    <header>
		<div class="logo">
		  <img src="logo.png" alt="Collab Nexus Logo">
		  <h1>Task Troopers: Login</h1>
		</div>
  </header>
	<Section>
		<div class="form">
			<form action="login.php" method="post">
				<h1>Username or Email</h1>
				<input type = "text" name="username" placeholder="Enter Username or Email"><br>
				<h1>Password</h1>
				<input type = "password" name="password" placeholder="Enter Password"><br>
				<input type = "submit" name = "submit" value = "Log in">
			</form>
				<?php
				include("connect.php");
				if(isset($_POST['submit'])){
				$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
				$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

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
						$_SESSION["username"] = $username;
						echo "<script> location.href='index.php'; </script>";
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
			<h1 class="alternative">Dont have an account? Then register <a href="register.php">here</a></h1>
		</div>
    </Section>
</body>
</html>
