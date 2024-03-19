<!DOCTYPE html>
<html>
    <body>
    <canvas id="Canvas" height="100vh" width="100vw" style="border: 1px solid black;"></canvas>
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

        window.addEventListener("resize", function() {
            // Update canvas size when iframe is resized
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight * 0.85;
        });

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
            ctx.strokeStyle = "black";
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

            //creates a formData and appends all the data to it, which allwos us to send it all at once to the php file
            var formData = new FormData();
            formData.append('image', blob);
            formData.append('groupid', groupid);
            formData.append('username', username);

            $.ajax({
                type: "POST",
                url: "saveimage.php",
                data: formData,
                processData: false,
                contentType: false
            });
        });
    });
});


    </script>
    </body>
</html>