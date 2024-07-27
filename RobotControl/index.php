<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robot Control</title>
    <!-- Internal CSS for styling the page and buttons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .button-container {
            display: grid;
            grid-template-areas:
                ". up ."
                "left stop right"
                ". down .";
            gap: 10px;
        }
        button {
            width: 80px;
            height: 80px;
            background-color: #FFFFFF;
            color: #000000;
            border: 2px solid transparent;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        button:active {
            border-color: #FF0000;
        }
        button.stop {
            grid-area: stop;
            background-color: #FF0000;
            color: #FFFFFF;
        }
        button.up {
            grid-area: up;
        }
        button.down {
            grid-area: down;
        }
        button.left {
            grid-area: left;
        }
        button.right {
            grid-area: right;
        }
    </style>
    <!-- Internal JavaScript for handling button clicks -->
    <script>
        function recordDirection(direction) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "record.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log("Direction recorded successfully.");
                    } else {
                        console.error("Error recording direction.");
                    }
                }
            };
            xhr.send("direction=" + direction);
        }
    </script>
</head>
<body>
    <!-- Container for directional buttons -->
    <div class="button-container">
        <!-- Buttons for robot control -->
        <button type="button" onclick="recordDirection('forward')" class="up">Forward</button>
        <button type="button" onclick="recordDirection('backward')" class="down">Backward</button>
        <button type="button" onclick="recordDirection('left')" class="left">Left</button>
        <button type="button" onclick="recordDirection('right')" class="right">Right</button>
        <button type="button" onclick="recordDirection('stop')" class="stop">Stop</button>
    </div>
</body>
</html>
