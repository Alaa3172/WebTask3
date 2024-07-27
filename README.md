# Web Task 3
This task demonstrates how to use an ESP32 microcontroller to retrieve data from a database using HTTP requests. The data is hosted on a database set up with Hostinger, and the ESP32 is simulated using Wowki. The example focuses on controlling a robot by recording and retrieving directional commands.

## Prerequisites
* Hostinger account
* Basic knowledge of HTML, PHP, and MySQL
* ESP32 microcontroller or Wowki simulator account

## Setup

### Hostinger Setup
1. Create a Hostinger account:
  * Go to Hostinger and sign up for an account.
  * Choose a hosting plan and set up your domain.
2. Set Up Your Website:
  * Log in to the Hostinger control panel.

  <img width="958" alt="image" src="https://github.com/user-attachments/assets/3ee04bdf-11e6-4ffc-8476-6f7e39ebeebd">

  * Go to the “Website” section and click on “Dashboard” for your domain.

  ![image](https://github.com/user-attachments/assets/5622b180-c285-472b-95ba-3af904f90b0b)

  * Click on __“File Manager”__ and click on the __"public_html"__ directory.

  ![image](https://github.com/user-attachments/assets/43eb7ac2-8a1f-4307-9759-c07f2c90972b)

  ![image](https://github.com/user-attachments/assets/e2628dc1-3b2c-49e3-a116-da2c8638b337)

  * Create a project folder in the directory. (Give it the same name as the project folder in Task 1 and 2)

  ![image](https://github.com/user-attachments/assets/356bc3a9-0c7f-49e7-8097-ae282d5ead71)

  * Upload the HTML and PHP files in the folder. (Use the files in Task 1 and 2.)

  ![image](https://github.com/user-attachments/assets/5cace4f7-2a76-42cd-9aa0-2399dbb8aea3)

## Database Setup
1. Create a Database:
  * In the Hostinger control panel, navigate to the “Databases” section.
  
  ![image](https://github.com/user-attachments/assets/14f3d17d-6812-4ffb-a014-d7ffc20fe3d6)

  * Under __"Create a New MySQL Database And Database User"__ enter a database name, username, and password.

  ![image](https://github.com/user-attachments/assets/aa644026-e4bb-4ef7-8c41-6289db1a3617)

2. Upload Database Files:
  * On the same page, under __"List of Current MySQL Databases And Users"__, click on __“Enter phpMyAdmin”__.
  
  ![image](https://github.com/user-attachments/assets/db70cd8b-e649-4dc9-9bb3-54c9533f8d77)

  * Ensure the table directions with columns id and direction is created.

  ![image](https://github.com/user-attachments/assets/fdc4a2a9-11d9-4873-b68d-48b0e2798f07)

  ![image](https://github.com/user-attachments/assets/3dc308a1-4977-4eeb-bcbe-54b09b135d9c)

3. Go back to the PHP files uploaded in the __"public_html"__ directory and make the following changes:
  * Change the servername to the server number in the database.

  ![image](https://github.com/user-attachments/assets/7d297a08-9864-438f-a5a9-b511ddf0ab74)

  * Change the database name, username, and password to those entered in the database setup.

  ![image](https://github.com/user-attachments/assets/cfd056ee-c41b-4efa-b7b4-f475a5605564)

  ![image](https://github.com/user-attachments/assets/25d2042f-58a7-4784-8631-11fe4697a440)

## ESP32 Simulation on Wowki
1. Create a Wowki Account:
  * Go to Wowki and sign up for an account.
  * Open this [link](https://wokwi.com/projects/393020133767191553).

2. ESP32 Code:
  * Replace the example URL in the code with the link to your domain page that displays the last recorded direction. (PHP file not HTML)
  ```
  #include<WiFi.h>
  #include <HTTPClient.h>
  const char* ssid = "Wokwi-GUEST";
  const char* pass = "";
  
  unsigned const long interval = 2000;
  unsigned long zero = 0;
  
  void setup(){
    Serial.begin(115200);
    WiFi.begin(ssid, pass);
    while(WiFi.status() != WL_CONNECTED){
      delay(100);
      Serial.println(".");
    }
    Serial.println("WiFi Connected!");
    Serial.println(WiFi.localIP());
  
  }
  
  void loop(){
  
    if(millis()-zero > interval){
  
      HTTPClient http;
      http.begin("https://peachpuff-falcon-998348.hostingersite.com/robotcontrol/last.php");
      int httpResponCode = http.GET();
      Serial.println(httpResponCode);
      if(httpResponCode > 0){
        String payload = http.getString();
        Serial.print(payload);
      }else{
        Serial.print("error ");
        Serial.println(httpResponCode);
      }
  
      zero = millis();
    }
    
  }
  ```
3. Upload the Code:
  * Upload the ESP32 code to the Wowki simulator.
  * Ensure the ESP32 is connected to the same network as your Hostinger server.

## File Descriptions
* __index.php:__ Contains the HTML for the last recorded direction interface.
* __record.php:__ Contains the HTML for the robot control interface with buttons and handles recording the direction to the database.
* __last.php:__ Retrieves the last recorded direction from the database.
* __ESP32 Code:__ The code for the ESP32 to make HTTP requests.
Files can be found in the project directory __"robotcontrol"__.

## Usage
1. Open the HTML page in your browser to control the robot.
2. Click the buttons to send directions to the database.
3. The ESP32 will retrieve the last recorded direction every 2 seconds and display it in the serial monitor.

## Code
1. __index.php:__

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Last Recorded Direction</title>
</head>
<body>
    <div>
        Last recorded direction: <span id="direction"></span>
    </div>

    <script>
        // Function to fetch direction data from direction.php
        function fetchDirection() {
            fetch('last.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('direction').textContent = data;
                })
                .catch(error => {
                    console.error('Error fetching direction:', error);
                });
        }

        // Call fetchDirection function when the page loads
        window.onload = function() {
            fetchDirection();
        };
    </script>
</body>
</html>
```

2. __record.php:__

```
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
            xhr.open("POST", "record.php", true); // Use index.php as the URL for posting data
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
    
    <?php
    // Process form submission when the HTTP method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Connect to MySQL
        $servername = "127.0.0.1:3306";
        $username = "u211167529_alalkashgari"; // Replace with your actual database username
        $password = "Straykids03252002"; // Replace with your actual database password
        $dbname = "u211167529_robot_control"; // Replace with your actual database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            // If connection fails, output an error message and terminate script
            die("Connection failed: " . $conn->connect_error);
        }

        $direction = $_POST["direction"]; // Retrieve direction value from POST data

        // Insert into database
        $sql = "INSERT INTO directions (direction) VALUES ('$direction')";

        // Execute SQL query and check if successful
        if ($conn->query($sql) === TRUE) {
            // If insertion is successful, output success message
            echo "<script>console.log('Direction recorded successfully.');</script>";
        } else {
            // If there is an error with the SQL query, output error message
            echo "<script>console.error('Error recording direction.');</script>";
        }

        // Close connection to MySQL
        $conn->close();
    }
    ?>
</body>
</html>
```

3. __last.php:__

```
<?php
// Database connection details
$servername = "127.0.0.1:3306"; // Replace with actual hostname
$username = "u211167529_alalkashgari";   // Replace with actual username
$password = "Straykids03252002";   // Replace with actual password
$dbname = "u211167529_robot_control";  // Replace with actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select last recorded direction from database
$sql = "SELECT direction FROM directions ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the last recorded direction
    $row = $result->fetch_assoc();
    echo $row["direction"];
} else {
    echo "No directions recorded yet.";
}

// Close connection to MySQL
$conn->close();
?>
```

## Comment
This is the [link](https://wokwi.com/projects/403234656863599617) to my wowki page with my domain as an example.
