<!DOCTYPE html>
<html>
    <body>
    <canvas id="Canvas" height="100vh" width="100vw" style="border: 1px solid black;"></canvas>
    <br>
    <button onclick="changecolor('black')" style="background-color: black; color: black;">COLOUR</button>
    <button onclick="changecolor('red')" style="background-color: red; color: red;">COLOUR</button>
    <button onclick="changecolor('blue')" style="background-color: blue; color: blue;">COLOUR</button>
    <button onclick="changecolor('green')" style="background-color: green; color: green;">COLOUR</button>
    <button onclick="changecolor('#FFD700')" style="background-color: #FFD700; color: #FFD700;">COLOUR</button>
    <button onclick="changecolor('#FFA500')" style="background-color: #FFA500; color: #FFA500;">COLOUR</button>
    <button onclick="changecolor('purple')" style="background-color: purple; color: purple;">COLOUR</button>
    <button onclick="changecolor('pink')" style="background-color: pink; color: pink;">COLOUR</button>
    <br>
    <button onclick="selectTool('draw')">Draw</button>
    <button onclick="selectTool('erase')">Erase</button>
    <br>
    <button id="sendimage">Send Image</button>
    <script>
        const canvas = document.getElementById("Canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        var drawing = false;
        var previousX = 0;
        var previousY = 0;
        var tool = 'draw'; // Default tool is drawing
        var colour = "black";

        window.addEventListener("resize", function() {
            // Update canvas size when iframe is resized
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight * 0.75;
        });

        canvas.addEventListener("mousedown", function (e){
            drawing = true;
            // Set previous coordinates
            previousX = e.offsetX;
            previousY = e.offsetY;
        });

        canvas.addEventListener("mousemove", function (e){
            if(drawing){
                if(tool === 'draw'){
                    draw(e.offsetX, e.offsetY);
                } else if(tool === 'erase'){
                    erase(e.offsetX, e.offsetY);
                }
                previousX = e.offsetX;
                previousY = e.offsetY;
            }
        });

        canvas.addEventListener("mouseup", function(e){
            drawing = false;
        });

        function changecolor(newcolor){
            colour = newcolor; 
        }

        function selectTool(selectedTool){
            tool = selectedTool;
        }

        function draw(x, y){
            ctx.beginPath();
            ctx.moveTo(previousX, previousY);
            ctx.lineTo(x, y);
            ctx.strokeStyle = colour;
            ctx.lineWidth = 2;
            ctx.stroke();
            ctx.closePath();
        }

        function erase(x, y){
            ctx.beginPath();
            ctx.moveTo(previousX, previousY);
            ctx.lineTo(x, y);
            ctx.strokeStyle = 'white'; // Erase using white color
            ctx.lineWidth = 20;
            ctx.stroke();
            ctx.closePath();
        }

        function saveimage(){
            const dataURI = canvas.toDataURL();
            console.log(dataURI);
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#sendimage").click(function(){
                canvas.toBlob(function(blob) {
                    var groupid = <?php echo json_encode($_GET['groupid']);?>;
                    var username = <?php echo json_encode($_GET['username']);?>;

                    var formData = new FormData();
                    formData.append('image', blob);
                    formData.append('groupid', groupid);
                    formData.append('username', username);

                    $.ajax({
                        type: "POST",
                        url: "saveimage.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            window.parent.location.reload();
                        }
                    });
                });
            });
        });
    </script>
    </body>
</html>
