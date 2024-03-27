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
  <title>Educator Group</title>
  <link rel="stylesheet" href="style3.css">
  <style>

.dropbtn {
  background-color: #3498DB;
  color: white;
  padding: 15px;
  font-size: 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-left: auto;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  width: 100%;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
  
</head>
<body id="studentGroupBody">
  <div id="nav-bar" style="width: 150px">
    <button class="backButton" onclick="goto('index.php')">&larr; Home</button>

    <div id="channels" style="background: white;">
      <h4 style='margin-bottom: 5px'>Discussions</h4>
      <?php
          $groupid = $_GET['groupid'];
          $sql = "SELECT discussionName FROM discussions where groupid = '$groupid'";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
              $channelName = $row['discussionName'];
              echo "
    <button onclick=\"goto('EducatorGroups.php?groupid=".$groupid."&channel=".$channelName."')\" style='background: none; font-size: 20px; color: black; text-decoration: underline;'>$channelName</button><br>
";

          }
      ?>

      <div id="groupheader" class="groupdisplay" >
				<button style="font-size:18px; width: 100%; margin-left: 0; padding:5px; margin-bottom: 0px; background-color: #48a1f8; color: white;" >
          <b href="javascript:void(0)" class="addgroup" onclick="appearModal('modalDiscussion')" style='cursor:pointer; color:white;'>Create Discussion</b>
				</button>
			</div>
      
    </div>
    
    <button type="button" onclick="showannouncement()" style="font-size: 20px; width:100%; margin-left: 0; margin-bottom: 0px"> View Announcements </button>
    <button type="button" onclick="appearModal('modalAnnouncement')" style="font-size: 20px; width:100%; margin-left: 0; margin-bottom: 0px"> Make New Announcement </button>


    <div class="dropdown">
  <button onclick="toggleDropdown()" class="dropbtn">Create options</button>
  <div id="myDropdown" class="dropdown-content">
   
          
    <button onclick="openForm('popupForm2')" style='font-size: 15px'>Create Student Group</button>
    <button onclick="openForm('popupForm1')" style='font-size: 15px; width: 93%;'>Add Student</button>
    <button onclick="openForm('popupForm')" style='font-size: 15px'>Create Student Account</button>

  </div>
</div>



  </div>
  







  <div id="chat">
    
    <div id="header" style="background-color: #48a1f8; width:auto; padding: 5px; position: relative; z-index: 1;">
    <?php
        $groupid = $_GET['groupid'];
        $sql = "SELECT groupname FROM educatorgroup WHERE groupid = '$groupid'";
        $result = mysqli_query($conn, $sql);
        $groupname = mysqli_fetch_assoc($result)['groupname'];
        echo "<h3 style='text-align:center; font-size: 30px;'>".$groupname."</h3>";
      ?>
    </div>

    <div id = "outerchat">
    <div id ="chatdiv">

    <div class = 'chatcontainer'>

    </div>
    </div>
    <div id="inputContainer">
      <form id='chatform' method='post'>
        <input type='text' id='messageInput' placeholder='Type your message...' name = 'message'>
      </form>
    </div>
  </div>

  <div id="annbody" class="announcements" style="display: none">
  </div>
  </div>
  
  
  <div id="members-bar">

      <?php
          $sql = "SELECT joincode FROM educatorgroup WHERE groupid = '$groupid'";
          $result = mysqli_query($conn, $sql);
          $code = mysqli_fetch_assoc($result)['joincode'];
          echo"
          <h4 style= 'margin-top:0px'> Join Code: </h4>
          <h3 style= 'font-size: 15px; padding: 10px; margin-left:0px; background-color: white; color: black; width: 100%; margin-top: 0px'>
          ".$code."
          </h3>";
      ?>



    <div id="members" style="background: #48a1f8; width: 100%; margin-left: 0; color: white;">
      <h3 style= "margin-left: 28%; font-size: 20px;">Educators</h3>
    </div>
    <div id="members-list">
      <br>
      <ul>
        <?php
            $sql = "SELECT user FROM educatorgroups2users WHERE groupid='$groupid'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              $username = $row['user'];
              echo"
                <li class='users' style='color:black;'>".$username."</li><br>
              ";
            }     
        ?>
      </ul>
    </div>


					
	
					
				
				
		</section>

    

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <?php
  $channel = $_GET['channel'];
  $webname = "EducatorGroups.php?groupid=" . $groupid . "&channel=" . $channel . "";
  ?>

<script>
$(document).ready(function(){
    var lastTimestamp = 0;
    var discussion = "<?php echo $_GET['channel'];?>";
    var groupid = <?php echo $_GET['groupid'];?>;

    function fetchNewMessages() {
        $.ajax({
            url: 'fetch_messages.php',
            type: 'GET',
            data: {
                lastTimestamp: lastTimestamp,
                discussion: discussion,
                groupid: groupid
            },
            dataType: 'json',
            success: function(response) {
                if (response.length > 0) {
                    lastTimestamp = response[response.length - 1].timeSent;

                    response.forEach(function(message) {
                        var $chatMessage = $('<div class="chatmessage"></div>');
                        $chatMessage.append('<p class="messagesender">' + message.user + '<br></p>');
                        $chatMessage.append('<p style="color: black">' + message.messageText + '<br></p>');
                        $('#chatdiv .chatcontainer').append($chatMessage);
                    });

                    $('#chatdiv').scrollTop($('#chatdiv')[0].scrollHeight);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching new messages:', error);
            }
        });
    }
	
	function fetchNewAnnoucements() {
        $.ajax({
            url: 'fetch_announcements.php',
            type: 'GET',
            data: {
                lastTimestamp: lastTimestamp,
                discussion: discussion,
                groupid: groupid
            },
            dataType: 'json',
            success: function(response) {
                if (response.length > 0) {
                    lastTimestamp = response[response.length - 1].timeSent;

                    response.forEach(function(message) {
                        var $announcement = $('<div class="announcement"></div>');
                        $announcement.append('<p style="color: black;"> <strong>' + message.sender + '</strong>  <br> <br>' +  message.announcementtext + '<br> <br>' + message.timesent + '</p>');
                        $('#annbody').prepend($announcement);
                    });

                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching new announcements:', error);
            }
        });
    }
	
	

    setInterval(fetchNewMessages, 300);
	setInterval(fetchNewAnnoucements, 1000);
});

</script>


      <div class="popup" id="popupForm2" style="display: none;">
		    <h15 style="margin-bottom: 10px; font-size: 20px; padding: 15px ">Create student group</h15>
       
        <form method="post" id="groupform" action="createGroupEducator.php" style="font-size: 18px; padding: 10px;">
        <input type='text' name='groupName' placeholder='Group Name' style="font-size: 15px; padding: 5px; margin-top: 10px"><br>
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
		    
		    <input type='submit' name='groupcreate' value='Create Group' style="width: auto;">
		    </form>
	      <button onclick="closeForm('popupForm2')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
      </div>
   

      
					
						<div class="popup" id="popupForm1" style="display: none;">
							<form method="post"  id="adduser">
 							<h15 style="margin-bottom: 10px; font-size: 20px; padding: 5px ">Enter student username</h1>
							<input type="text" name = "studentusername" placeholder="Username">
							</form>
						<button onclick="closeForm('popupForm1')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
					</div>

      

          
						
							<div class="popup" id="popupForm" style="display:none">
								<h14 style="font-size: 20px;">Create Student Account</h14>
									<form method="post"  id="accountCreate" style="padding: 10px;">
									<h15 style="font-size: 15px; padding-left: 5px;">Enter username</h1>
									<input type = "text" name="username" placeholder="Username"><br>
									<h15 style="font-size: 15px; padding-left: 5px;">Enter password</h1>
									<input type = "password" name="password" placeholder="Password"><br>
									<h15 style="font-size: 15px; padding-left: 5px;">Enter email</h1>
									<input type = "text" name="email" placeholder="Email"><br>
									<input type = "submit" name = "submit" value = "Register">
								  </form>
							  <button onclick="closeForm('popupForm')" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
					  	</div>
				

      <dialog id="modalAnnouncement">
		    <button onclick="disappearModal('modalAnnouncement')" style="background-color: azure; color: black; font-size: 20px; right: 10px">Close</button><br>
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

          function showannouncement(){
            document.getElementById("outerchat").style.display = "none";
            document.getElementById("annbody").style.display = "block";
          }


  function toggleDropdown() {
    var dropdown = document.getElementById("myDropdown");
    dropdown.classList.toggle("show");
  }

  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }


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
    $("#chatform").submit(function(e){
		e.preventDefault();
        var message = $("input[name='message']").val();
        var groupid = <?php echo json_encode($groupid); ?>;
        var channel = <?php echo json_encode($channel); ?>;
        var username = <?php echo json_encode($username); ?>;
		$("#messageInput").val('');
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
		window.location.reload();
    })
})

$(document).ready(function(){
    $("#createAnnouncement").submit(function(e){
		e.preventDefault();
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
				disappearModal('modalAnnouncement');		
            }
        })
    })
})

	</script>
</body>




<dialog id="modalDiscussion">
		<button onclick="disappearModal('modalDiscussion')" style='background: azure;color: black;color: black;font-size: 20px;position: absolute;right: 10px;top: 10px;'>Close</button><br>
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
			
		</section>

</html>
