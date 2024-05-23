<?php
// Start the session at the top
session_start();

// Include the Database class
require_once 'Database.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Initialize the Database class
    $db = new Database();
    $conn = $db->getConnection();

    // Check if the connection was successful
    if ($conn) {
        // Prepare the SQL statement with named placeholders
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if the user exists and password is correct
        if ($row && password_verify($password, $row["password"])) {
            // session variables
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $row["role"];
            $_SESSION['message'] = "Login successful! Welcome $username.";
            
            // dashboard redirect
            if($row["role"] == 'admin'){
                header("Location: ../templates/admin_dashboard.php");
            exit();
            } else {
                header("Location:../templates/alumni_dashboard.php");
            }
            exit();
        } else {
            // Invalid username or password
            $_SESSION['message'] = "Invalid username or password!";
            header("Location: ../templates/login.php");
        }
    } else {
        $_SESSION['message'] = "Database connection failed!";
        header("Location: ../templates/login.php");
    }

    $conn = null;
}
?>
