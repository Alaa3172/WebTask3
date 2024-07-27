<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Recorded Direction</title>
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
        .direction-box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 300px;
            height: 150px;
            background-color: #FFFFFF;
            border: 2px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="direction-box">
        <div>Last Recorded Direction:</div>
        <div>
            <?php
            // Connect to MySQL
            $servername = "localhost";
            $username = "root"; 
            $password = "";
            $dbname = "robot_control"; // Database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch last recorded direction
            $sql = "SELECT direction FROM directions ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $direction = ucfirst($row["direction"]);
                echo htmlspecialchars($direction);
            } else {
                echo "No directions recorded yet.";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
