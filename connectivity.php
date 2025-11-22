<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // 
        $name = htmlspecialchars($_POST['name']);
        $age = $_POST['age']; // 
        $locality = htmlspecialchars($_POST['locality']);
        $Email = htmlspecialchars($_POST['Email']);
        $number = htmlspecialchars($_POST['number']);
        
        // 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "gym";

        // 
        $conn = new mysqli($servername, $username, $password, $database);

        // 
        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        else { 
            // 
            // Instead of putting variables directly in the query, we use '?' placeholders.
            $stmt = $conn->prepare("INSERT INTO `details` (`name`, `age`, `locality`, `Email`, `number`) VALUES (?, ?, ?, ?, ?)");
            
            // 
            // "sisss" means: String, Integer, String, String, String
            // This tells the database exactly what type of data to expect.
            $stmt->bind_param("sisss", $name, $age, $locality, $Email, $number);

            // 
            if($stmt->execute()){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your details have been submitted successfully. <br>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <a href="index.html" style="text-decoration:none; color:inherit;">Return Home</a>
                </button>
                </div>';
            }
            else{
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> We faced a technical issue. Please try again later.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div>';
                // Debugging line (Remove this before showing a real recruiter):
                // echo "Error: " . $stmt->error;
            }

            // 
            $stmt->close();
            $conn->close();
        }
    }
?>