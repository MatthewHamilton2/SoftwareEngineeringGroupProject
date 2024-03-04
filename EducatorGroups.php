<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>

<html>

<head>


	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<header>
	<span class="navSpan" onclick="openNav()">&#9776;</span>
	<div class="logo">
		<img src="placeHolder.PNG" alt="Collab Nexus Logo">
		<h1>Educator Groups</h1>
	</div>
	<div class="profile">
		<img src="profile.png" alt="Profile Picture" class="profile-picture">
	</div>
</header>

<body class="unset">

	<div id="main">


	<div id="sidenavbar" class="sidenav" >


<a href="index.php">Home</a>
<a href="Profile.html" class="split">My Profile</a>
<a href="settings_page/settings.html" class="split">Settings</a>
<a href="logout.php" class="split">Logout</a>
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

</div>

		<section>
			<div id="annheader" class="announcements">
				<span>
				 <button id="CreateStudentAccountButton" onclick="openForm('popupForm')">Create Student Account</button>	<button id ="addStudentToGroup" onclick="openForm('popupForm1')">Add Student</button><button id="createStudnetGroup" onclick="openForm('popupForm2')">Create student group</button><button type="button" onclick="appearModal('modalAnnouncement')"> Make New Announcement </button>

					
	
					
					<h3>Recent announcements</h3>
				
				</span>
			</div>
			<div id="annbody" class="announcements">
				<?php
				$groupid = $_GET['groupid'];
				$sql = "SELECT announcementtext, sender, timesent FROM announcements WHERE groupid = '$groupid' ORDER BY timesent DESC LIMIT 3";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)) {
					$text = $row['announcementtext'];
					$displayedtext = substr($text, 0, 150) . "...";
					$sender = $row['sender'];
					$time = $row['timesent'];
					echo "
					<div class='announcement'>
					<p>" . $sender . "<br>" . $displayedtext . "<br>" . $time . "</p>
					</div>
					";
				}
				?>
			</div>
		</section>

	</div>

	<section id="groupsection">

		<div id="groupdisplaybar" class="groupdisplay">

			<div id="groupheader" class="groupdisplay">
				<span style="font-size:30px;">
					<h3>Groups</h3> <a href="javascript:void(0)" class="addgroup" onclick="appearModal('modalDiscussion')">&plus;</a>
				</span>
			</div>

			<div id="groups" class="groupdisplay">

				<ul>
					<?php
					$sql = "SELECT discussionName FROM discussions WHERE groupid = '$groupid'";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_assoc($result)) {
						$name = $row['discussionName'];
						echo " <a href='discussion.php?groupid=" . $groupid . "&name=" . $name . "'>
						<li><h3>" . $name . "</h3></li>
						</a>
						";
					}
					?>
				</ul>


			</div>
		</div>
	</section>

	<section id="chatsection">
		<div id="chatboxdisplay" class="chatbox">
			<div id="chatheader" class="chatbox">
				<h1>Group1 Preview</h1>
			</div>
			<div id="chatcontent" class="chatbox">
				<ul>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>
					<li>
						<h3>message1</h3>
					</li>

				</ul>
			</div>
		</div>
	</section>

	<dialog id="modalAnnouncement">
		<button onclick="disappearModal('modalAnnouncement')">X</button><br>
		<?php
		$groupid = $_GET['groupid'];
		echo "
            <Form action='createAnnouncement.php?groupid=" . $groupid . "' method='post'>
				<input type = 'text' placeholder = 'Announcement' id='announcementBox' name='announcementText' maxnumber='100'>
				<input type='submit'>
			</Form>
			"
		?>
	</dialog>

	<dialog id="modalDiscussion">
		<button onclick="disappearModal('modalDiscussion')">X</button><br>
		<?php
		$groupid = $_GET['groupid'];
		echo "
            <Form action='createDiscussion.php?groupid=" . $groupid . "' method='post'>
				<input type = 'text' placeholder = 'Discussion Name' name='discussionName' maxnumber='100'>
				<input type='submit'>
			</Form>
			"
		?>
	</dialog>

	<script>
		window.onload = closeNav();

		function openNav() {
			document.getElementById("sidenavbar").style.width = "250px";
			document.getElementById("sidenavbar").style.display = "block";
			document.getElementById("main").style.marginLeft = "250px";

		}

		function closeNav() {
			document.getElementById("sidenavbar").style.width = "0";
			document.getElementById("sidenavbar").style.display = "none";
			document.getElementById("main").style.marginLeft = "0";
		}

		function appearModal(modal) {
			document.getElementById(modal).showModal();
		}

		function disappearModal(modal) {
			document.getElementById(modal).close();
		}
	</script>
	</div>
</body>


<!--
	form and code to make a student account from the educator page; in final version, this should only be visible to educators; border is here to make it easier to discern where section ends

	Whether this should be on the Educator Group pages (probably shouldnt) or anywhere else is up to you; put it wherever you feel fits

	issues: only works with non-empty values - will fix later

	go to lines 49-66 for code to create a student account from the educator page -- Alex
-->


					<div>
						
							<div class="popup" id="popupForm" style="display:none">
								<h14>Create Student Account</h14>
									<form method="post" style="border: 5px solid black" id="accountCreate">
									<h1>Enter username</h1>
									<input type = "text" name="username" placeholder="Username"><br>
									<h1>Enter password</h1>
									<input type = "password" name="password" placeholder="Password"><br>
									<h1>Enter email</h1>
									<input type = "text" name="email" placeholder="Email"><br>
									<input type = "submit" name = "submit" value = "Register">
								</form>
							<button onclick="closeForm('popupForm')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
						</div>
					</div>

<!--
	form and code to add student to educator group; in final version, this should only be visible to educators; border is here to make it easier to discern where section ends;
	
	issues: works only if non-empty values - will fix later

	see lines for 68-77 for code to add student to educator group -- Alex
-->
		
<div>
					
						<div class="popup" id="popupForm1" style="display: none;">
							<form method="post" style="border: 5px solid red" id="adduser">
 							<h1>Enter student username</h1>
							<input type="text" name = "studentusername" placeholder="Username">
							</form>
						<button onclick="closeForm('popupForm1')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
					</div>

</div>

<!--
	code which creates a form for creating a student group with members of the educator group;

	issues: works only if non-empty values - will fix later
-->
<div>
	

	<div class="popup" id="popupForm2" style="display: none;">
		<h15>Create student group</h15>
		<form method="post" id="groupform" action="createGroupEducator.php">
		<?php
			$sql = "SELECT user FROM educatorgroups2users WHERE groupid = ".$groupid;
			$result = mysqli_query($conn, $sql);
			echo"<form method='post' id='groupform' action='createGroupEducator.php'>";
			while($row = mysqli_fetch_assoc($result)){
				$name = $row["user"];
				if(!($name == $_SESSION['username'])){
				echo"
				<input type='checkbox' name='user[]' value='".$name."' id='".$name."'>
				<label for='".$name."'>".$name."</label><br>
			";
			}
		}
		?>
		<input type='text' name='groupName' placeholder='Group Name'>
		<input type='submit' name='groupcreate' value='creategroup'>
		</form>
	<button onclick="closeForm('popupForm2')">Close</button>

<script>
	//function for adding a user to the educator group
	$(document).ready(function(){
		$("#adduser").submit(function(){
			var user = $("input[name='studentusername']").val();
			$.ajax({
				type: "POST",
				url: "inviteStudentToEducatorGroup.php",
				data: 
				{	
					groupid: "<?php echo $groupid;?>",
					username: user
				},
				success: function(response) {
					console.log(response);
				}
			})
		})
	})

	//function for creating a student group from the educator page; doesnt work for now but ill try and make it work later; fucntionality is still there but it doesnt use this function
	/*
	$(document).ready(function(){
		$("#groupform").submit(function(){
			var students = $("input[name='user[]']").val();
			$.ajax({
				type: "POST",
				url: "createGroupEducator.php",
				data: 
				{
					user: students
				},
				success: function(response) {
					console.log(response);
				}
			})
		})
	})
	*/

	$(document).ready(function(){
		$("#accountCreate").submit(function(){
			var user = $("input[name='username']").val();
			var pass = $("input[name='password']").val();
			var em = $("input[name='email']").val();
			$.ajax({
				type: "POST",
				url: "createAccount.php",
				data: 
				{	
					username: user,
					password: pass,
					email: em
				},
				success: function(response) {
					console.log(response);
				}
			})
		})
	})
</script>


<script>
	//function for opening/closing the form
	
    function goto(destination){
        location.href = destination;
    }

    function openForm(formId){
      document.getElementById(formId).style.display = "block";
    }

    function closeForm(formId){
      document.getElementById(formId).style.display = "none";
    }

</script>



</html>
