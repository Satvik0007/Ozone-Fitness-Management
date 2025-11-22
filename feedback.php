<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // 1. Sanitize inputs to prevent Cross-Site Scripting (XSS)
        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']);
        $country = htmlspecialchars($_POST['country']);
        $subject = htmlspecialchars($_POST['subject']);
        
        // Database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "gym";

        // 
        $conn = new mysqli($servername, $username, $password, $database);

        // 
        if ($conn->connect_error){
            die("Sorry we failed to connect: " . $conn->connect_error);
        }
        else{ 
            // 
            // We use '?' placeholders instead of direct variables
            $stmt = $conn->prepare("INSERT INTO `feedback` (`fname`, `lname`, `country`, `subject`) VALUES (?, ?, ?, ?)");
            
            //
            // "ssss" means all 4 inputs are Strings
            $stmt->bind_param("ssss", $fname, $lname, $country, $subject);

            // 
            if($stmt->execute()){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Wait!</strong> Are you sure you want to submit? <br>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <a href="index.html">Confirm Now</a></button> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <a href="index.html">Edit Preferences</a>
                </button>
                </div>';
            }
            else{
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> We are facing some technical issue and your entry was not submitted successfully! We regret the inconvenience caused!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div>';
            }

            // 
            $stmt->close();
            $conn->close();
        }
    }
?>