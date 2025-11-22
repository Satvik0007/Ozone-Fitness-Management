<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // 
        $tid = htmlspecialchars($_POST['tid']);
        
        // 
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
            // We use '?' to safely insert the transaction ID
            $stmt = $conn->prepare("INSERT INTO `payment` (`tid`) VALUES (?)");
            
            // 
            // 's' means String (Transaction IDs are usually alphanumeric like 'TXN12345')
            $stmt->bind_param("s", $tid);

            // 
            if($stmt->execute()){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Payment Reference ID Submitted. <br>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <a href="index.html">Return Home</a></button> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <a href="payment_gateway.html">Edit Details</a>
                </button>
                </div>';
            }
            else{
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> We faced a technical issue recording your ID. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div>';
            }

            // 7. Clean up
            $stmt->close();
            $conn->close();
        }
    }
?>