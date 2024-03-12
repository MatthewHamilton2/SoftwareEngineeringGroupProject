<?php
  include("connect.php");
  session_start();
  $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>student-group-page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body id="studentGroupBody">
  <div id="nav-bar">
    <button class="backButton" onclick="goto('index.php')">&larr;</button>
    <div id="nav-bar-header">
    <?php
        $groupid = $_GET['groupid'];
        $sql = "SELECT groupname FROM educatorgroup WHERE groupid = '$groupid'";
        $result = mysqli_query($conn, $sql);
        $groupname = mysqli_fetch_assoc($result)['groupname'];
        echo "<h3 style='text-align:center; font-size: 20px;'>".$groupname."</h3>";
      ?>
      <button id="settings-button">Settings</button>
    </div>

    <div id="channels">
      <h4>Discussions</h4>
      <?php
          $sql = "SELECT discussionName FROM discussions where groupid = '$groupid'";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
              $channelName = $row['discussionName'];
              echo "
    <button onclick=\"goto('EducatorGroups.php?groupid=".$groupid."&channel=".$channelName."')\">$channelName</button><br>
";

          }
      ?>

      <div id="groupheader" class="groupdisplay">
				<span style="font-size:30px;">
          <a href="javascript:void(0)" class="addgroup" onclick="appearModal('modalDiscussion')">Create Discussion</a>
				</span>
			</div>


      <?php
          $sql = "SELECT joincode FROM educatorgroup WHERE groupid = '$groupid'";
          $result = mysqli_query($conn, $sql);
          $code = mysqli_fetch_assoc($result)['joincode'];
          echo"
          <h4> Join Code: </h4>
          <h3 style= 'margin-left:15px'>
          ".$code."
          </h3>";
      ?>
    </div>

    
  </div>
  







  <div id="chat">
    <div id ="chatdiv">
      <?php
      $groupid = $_GET['groupid'];
      $channel = $_GET['channel'];
        $sql = "SELECT * FROM (SELECT * FROM discussionmessage WHERE (groupid = ".$groupid." AND discussionName = '".$channel."') ORDER BY timeSent DESC) AS subquery ORDER BY subquery.timeSent ASC";
        $result = mysqli_query($conn, $sql);
        echo"<div class = 'chatcontainer'>";
        while($row = mysqli_fetch_assoc($result)){
            $message = $row['messageText'];
            $sender = $row['user'];
            echo "
            <div class='chatmessage'>
            <p class='messagesender'>$sender"."<br>"."</p>
            <p>$message"."<br>"."</p>
            </div>
            ";
        }
        echo"</div>";
      ?>
    </div>
    <div id="inputContainer">
      <form id='chatform' method='post'>
        <input type='text' id='messageInput' placeholder='Type your message...' name = 'message'>
      </form>
    </div>
  </div>
  <div id="members-bar">
    <div id="members">
      <h3>Educators</h3>
    </div>
    <div id="members-list">
      <ul>

      </ul>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <?php
  $channel = $_GET['channel'];
  $webname = "EducatorGroups.php?groupid=" . $groupid . "&channel=" . $channel . "";
  echo"
  <script>
    $(document).ready(function(){
      setInterval(function(){
        $('#chatdiv').load('".$webname." #chatdiv');
      }, 3000);
    });
  </script>
  "
  ?>

<div>
<div class="popup" id="popupForm2" style="display: none;">
		<h15 style="margin-bottom: 10px; font-size: 20px; padding: 5px ">Create student group</h15>
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
	<button onclick="closeForm('popupForm2')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
  </div>
  </div>

  <div>
					
						<div class="popup" id="popupForm1" style="display: none;">
							<form method="post" style="border: 5px solid red" id="adduser">
 							<h1 style="margin-bottom: 10px; font-size: 20px; padding: 5px ">Enter student username</h1>
							<input type="text" name = "studentusername" placeholder="Username">
							</form>
						<button onclick="closeForm('popupForm1')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
					</div>

</div>

<div>
						
							<div class="popup" id="popupForm" style="display:none">
								<h14>Create Student Account</h14>
									<form method="post" style="border: 5px solid black" id="accountCreate">
									<h1 style="font-size: 20px; padding-left: 5px;">Enter username</h1>
									<input type = "text" name="username" placeholder="Username"><br>
									<h1 style="font-size: 20px; padding-left: 5px;">Enter password</h1>
									<input type = "password" name="password" placeholder="Password"><br>
									<h1 style="font-size: 20px; padding-left: 5px;">Enter email</h1>
									<input type = "text" name="email" placeholder="Email"><br>
									<input type = "submit" name = "submit" value = "Register">
								</form>
							<button onclick="closeForm('popupForm')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
						</div>
					</div>

          <dialog id="modalAnnouncement">
		<button onclick="disappearModal('modalAnnouncement')">X</button><br>
		<?php
		$groupid = $_GET['groupid'];
		echo "
            <Form id='createAnnouncement' method='post'>
				<input type = 'text' placeholder = 'Announcement' id='announcementBox' name='announcementText' maxnumber='100'>
				<input type='submit'>
			</Form>
			"
		?>
	</dialog>


  
  <script>
    function goto(destination){
        location.href = destination;
    }


		function appearModal(modal) {
			document.getElementById(modal).showModal();
		}

		function disappearModal(modal) {
			document.getElementById(modal).close();
		}

    function openForm(formId){
      document.getElementById(formId).style.display = "block";
    }

    function closeForm(formId){
      document.getElementById(formId).style.display = "none";
    }

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

  $(document).ready(function(){
    $("#chatform").submit(function(){
        var message = $("input[name='message']").val();
        var groupid = <?php echo json_encode($groupid); ?>;
        var channel = <?php echo json_encode($channel); ?>;
        var username = <?php echo json_encode($username); ?>;
        $.ajax({
            type: "POST",
            url: "sendDiscussionMessage.php",
            data: {	
                message: message,
                groupid: groupid,
                channel: channel,
                username: username
            },
            success: function(response) {
                console.log(response);
            }
        })
    })
})

$(document).ready(function(){
    $("#createDiscussion").submit(function(){
        var discussionName = $("input[name='discussionName']").val();
        var groupid = <?php echo json_encode($groupid); ?>;
        $.ajax({
            type: "POST",
            url: "createDiscussion.php",
            data: {	
                discussionName: discussionName,
                groupid: groupid
            },
            success: function(response) {
                console.log(response);
            }
        })
    })
})

$(document).ready(function(){
    $("#createAnnouncement").submit(function(){
        var announcementText = $("input[name='announcementText']").val();
        var groupid = <?php echo json_encode($groupid); ?>;
        var username = <?php echo json_encode($username); ?>;
        $.ajax({
            type: "POST",
            url: "createAnnouncement.php",
            data: {	
                announcementText: announcementText,
                groupid: groupid,
                username: username
            },
            success: function(response) {
                console.log(response);
            }
        })
    })
})

	</script>
</body>




<dialog id="modalDiscussion">
		<button onclick="disappearModal('modalDiscussion')">X</button><br>
		<?php
		$groupid = $_GET['groupid'];
		echo "
            <Form id = 'createDiscussion' method='post'>
				<input type = 'text' placeholder = 'Discussion Name' name='discussionName' maxnumber='100'>
				<input type='submit'>
			</Form>
			"
		?>
	</dialog>


  <section>
			<div id="annheader" class="announcements">
				<span>
				 <button id="CreateStudentAccountButton" onclick="openForm('popupForm')">Create Student Account</button>	<button id ="addStudentToGroup" onclick="openForm('popupForm1')">Add Student</button><button id="createStudnetGroup" onclick="openForm('popupForm2')">Create student group</button><button type="button" onclick="appearModal('modalAnnouncement')"> Make New Announcement </button>

					
	
					
					<h3>Recent announcements</h3>
				
				</span>
			</div>
			<div id="annbody" class="announcements" style="display: none">
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

</html>