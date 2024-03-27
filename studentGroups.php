<?php
  include("connect.php");
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Group</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left:50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding : 20px;
      z-index: 9999;
    }
  </style>
</head>
<body id="studentGroupBody">
	<div id="nav-bar">
		<div id="sidenavbar" class="sidenav" style="display:none">
			<a href="index.php">Home</a>
			<a href="profilePage.html" class="split">My Profile</a>
			<a href="logout.php" class="split">Logout</a>
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		</div>
		<span class="navSpan" onclick = "openNav()">&#9776;</span>
    <br>
    <br>
    <br>
		<button id="event-button" onclick="openEvents()">Events</button>
    <br>
    <button id = "draw-button" onclick="startdraw()">Draw</button>
    <br>
    <button id = "chat-button" onclick="openchat()">Chat</button>
    <br>
    <button id = "image-button" onclick="openimage()">Images</button>
	
	</div>
  <div id="chat">
    
    <div id="nav-bar-header" style='border: 1px solid black; color: #0090ff'>
    <?php
        $groupid = $_GET['groupid'];
        $sql = "SELECT groupname FROM chatgroup WHERE groupid = '$groupid'";
        $result = mysqli_query($conn, $sql);
        $groupname = mysqli_fetch_assoc($result)['groupname'];
        echo "<h3 style='text-align:center; font-size: 30px;'>".$groupname."</h3>";
      ?>
    </div>

	
	<div id ="chatdiv" style="overflow-y: scroll;">
		<div style="display: none" id="event-overlay">
			<div id="event-content">
				<a href="javascript:void(0)" class="event-close" onclick="closeEvents()">X</a>
				<?php
					$sql = "SELECT * FROM events WHERE groupid='$groupid'";
					$result = mysqli_query($conn, $sql);
					echo "<div class='event-grid'>";
					
					if(mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$name = $row["eventname"];
							$eventid = $row["eventid"];
							$duration = $row["duration"];
							$starttime = date('Y-m-d', strtotime($row["starttime"]));

							// Acquire username from session
							$username = $_SESSION["username"];
							
							// Check if user is already in the event
							$sql_check_user_event = "SELECT * FROM events2users WHERE eventid='$eventid' AND username='$username'";
							$result_check_user_event = mysqli_query($conn, $sql_check_user_event);
							$is_user_in_event = mysqli_num_rows($result_check_user_event) > 0;

							echo "
							<div class='event-info'>
								<p><strong>Name: </strong>$name</p>
								<p><strong>Duration: </strong>$duration</p>
								<p><strong>Start Time: </strong>$starttime</p>
								<form method='post'>
									<button class='eventjoin' value='$eventid' style='width: 75%; background-color: azure; color: black; font-size: 20px; text-align:center; margin: auto;'>
									" . ($is_user_in_event ? 'Joined' : 'Join Event') . "</button>
								</form>
							</div>
							";
						}
					} else {
						echo "<div style='text-align: center; width:100%; display: block; margin: auto;'><p style='margin: 20px; text-align: center;'>No events planned..</p></div>";
					}
					echo "</div>";
				?>
				
			</div>
			
			<button id="create-event-button" onclick="openForm()" style="display: block; margin-top: 40px; font-size: 20px; padding: 20px; font-weight: bold; margin:auto;">Create Event</button>
		</div>
    <div id = "innerchat"><div class = 'chatcontainer'></div>
    </div>
    <div style="display: none" id = "imagechat">
      <?php
        $sql = "SELECT * FROM (SELECT * FROM imagesent WHERE groupid = ".$groupid." ORDER BY timeSent DESC) AS subquery ORDER BY subquery.timeSent ASC";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $sender = $row['sender'];
            $imagedata = $row['imagedata'];
            echo"
            <div class='chatmessage'>
            <p class='messagesender'>$sender<br></p>
            <img src='data:image/png;base64," . base64_encode($imagedata) . "' alt='Image' style='max-width: 85vw; max-height: 100%;'>
            </div>";
        }
      ?>
    </div>
    <?php
      $username = $_SESSION['username'];
      echo "
      <iframe src=\"imagePrototype.php?groupid=$groupid&username=$username\" title=\"description\" id=\"drawing-div\"></iframe>
      ";
    ?>
    <div id="inputContainer">
      <?php
      $groupid = $_GET['groupid'];
      echo"
      <form id='chatform' method='post' action='sendMessage.php?groupid=".$groupid."'>
        <input type='text' id='messageInput' placeholder='Type your message...' name = 'message'>
      </form>
      ";
      ?>
      </div>
    </div>
  </div>
  
  
  

  <div id="members-bar">
    <?php
		$sql = "SELECT joincode FROM chatgroup WHERE groupid = '$groupid'";
		$result = mysqli_query($conn, $sql);
		$code = mysqli_fetch_assoc($result)['joincode'];
		echo"
		<h4> Join Code: </h4>
		<h3 style= 'margin-left:15px; color: black;'>
		".$code."
		</h3>";
	?>

    <div class="popup" id="popupForm">
    <h13>Create Event</h13>
    <form method="post" id="createevent">
      <input type="text" name = "eventname" placeholder="Event Name" style="margin-top: 15px; margin-bottom: 10px; width: 97%;"><br>
      <input type="text" name = "description" placeholder="Description" style="margin-bottom: 10px; width: 97%;"><br>
      <input type="text" name = "maxparticipants" placeholder="Participants" style="margin-bottom: 10px; width: 97%;"><br>
      <input type="text" name = "duration" placeholder="Duration" style="margin-bottom: 10px; width: 97%;"><br>
      <input type="date" name = "starttime" placeholder="Date" style="width: 98%; margin-bottom: 10px; font-size: 15px;"><br>
      <input type="submit" value="Create Event" style="width: 98%; font-size: 15px;">
    </form>
    <button onclick="closeForm()" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
  </div>


    <div id="members">
      <h4 style="margin-left: 15px;">Members</h4>
    </div>
    <div id="members-list">
      <ul>
        <?php
          $sql = "SELECT user FROM groups2users WHERE groupid='$groupid'";
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
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
    var lastTimestamp = 0;
	  var groupid = <?php echo $_GET['groupid'];?>;
    function fetchNewMessages() {
        $.ajax({
            url: 'fetch_message_student.php',
            type: 'GET',
            data: { lastTimestamp: lastTimestamp,
					          groupid: groupid},
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
    setInterval(fetchNewMessages, 300);
});
</script>

  <script>

    function goto(destination){
        location.href = destination;
    }

    function openForm(){
      document.getElementById("popupForm").style.display = "block";
    }

    function closeForm(){
      document.getElementById("popupForm").style.display = "none";
    }
	
	function openEvents() {
        document.getElementById('imagechat').style.display = 'none';
        document.getElementById('event-overlay').style.display = 'block';
        document.getElementById('innerchat').style.display = 'none';
        var drawingdiv = document.getElementById('drawing-div-show');
        if(drawingdiv){
          drawingdiv.setAttribute('id', "drawing-div");
        }
        while(document.getElementById('drawing-div-show')){
        document.getElementById('drawing-div-show').setAttribute('id', "drawing-div");
      }
    }

    function closeEvents() {
        document.getElementById('event-overlay').style.display = 'none';
        document.getElementById('innerchat').style.display = 'block';
    }

    function openchat(){
        document.getElementById('imagechat').style.display = 'none';
        document.getElementById('event-overlay').style.display = 'none';
        document.getElementById('imagechat').style.display = 'none';
        document.getElementById('innerchat').style.display = 'block';
        var drawingdiv = document.getElementById('drawing-div-show');
        if(drawingdiv){
          drawingdiv.setAttribute('id', "drawing-div");
        }
        while(document.getElementById('drawing-div-show')){
        document.getElementById('drawing-div-show').setAttribute('id', "drawing-div");
      }
    }

    function openimage(){
        document.getElementById('imagechat').style.display = 'block';
        document.getElementById('event-overlay').style.display = 'none';
        document.getElementById('innerchat').style.display = 'none';
        var drawingdiv = document.getElementById('drawing-div-show');
        if(drawingdiv){
          drawingdiv.setAttribute('id', "drawing-div");
        }
        while(document.getElementById('drawing-div-show')){
        document.getElementById('drawing-div-show').setAttribute('id', "drawing-div");
      }
      while(document.getElementById('imagechat').style.display !== "block"){
        document.getElementById('imagechat').style.display = "block"
        document.getElementById('imagechat').scrollTop = document.getElementById('imagechat').scrollHeight;
      }

    }

    function startdraw(){
      document.getElementById('imagechat').style.display = 'none';
      document.getElementById('event-overlay').style.display = 'none';
      document.getElementById('innerchat').style.display = 'none';
      document.getElementById('inputContainer').style.display = 'none';
      var drawingdiv = document.getElementById('drawing-div');
      drawingdiv.setAttribute('id', "drawing-div-show");
      while(document.getElementById('drawing-div')){
        document.getElementById('drawing-div').setAttribute('id', "drawing-div-show");
      }
    }

        const canvas = document.getElementById("Canvas");
        const ctx = canvas.getContext("2d");
        var drawing = false;
        var previousX = 0;
        var previousY = 0;

        canvas.addEventListener("mousedown", function (e){
                drawing = true;
                //these are to stop the line from snapping to the new point, and drawing a conencting lie as it does
                previousX = e.offsetX;
                previousY = e.offsetY;
        });

        canvas.addEventListener("mousemove", function (e){
            //only draws if user is currently drawing
            if(drawing){
                    freehand(e.offsetX, e.offsetY);
                    previousX = e.offsetX;
                    previousY = e.offsetY;
            }
        });

        canvas.addEventListener("mouseup", function(e){
            //stops drawing when user releases mouse hold
                drawing = false;
        });

        function freehand(x, y){
            ctx.beginPath();
            ctx.moveTo(previousX,previousY);
            ctx.lineTo(x,y);
            ctx.strokeStyle = "red";
            ctx.stroke();
            ctx.closePath();
        }
  </script>
</body>
</html>

<script>
  $(document).ready(function(){
		$("#createevent").submit(function(){
			var eventname = $("input[name='eventname']").val();
			var maxparticipants = $("input[name='maxparticipants']").val();
			var starttime = $("input[name='starttime']").val();
      var duration = $("input[name='duration']").val();
      var username = "<?php $username = $_SESSION["username"]; echo $username;?>";
      var description = $("input[name='description']").val();
      var groupid = <?php echo $groupid?>;
			$.ajax({
				type: "POST",
				url: "createEvent.php",
				data: 
				{	
					eventname: eventname,
					maxparticipants: maxparticipants,
					starttime: starttime,
          duration: duration,
          username: username,
          description: description,
          groupid: groupid
				},
				success: function(response) {
					console.log(response);
				}
			})
		})
	})

  $(document).ready(function() {
    $('.eventjoin').click(function(){
      var eventid = ($(this).attr("value"));
      var username = "<?php $username = $_SESSION["username"]; echo $username;?>";
      $.ajax({
        type: "POST",
        url: "joinEvent.php",
        data: 
        {
          eventid: eventid,
          username: username
        }
      })
    })
  })
  
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