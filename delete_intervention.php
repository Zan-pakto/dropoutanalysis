<?php
session_start();

// Include authentication check
require_once 'includes/auth_check.php';

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'dropout_analysis';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if ID is provided
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        
        // Delete the intervention
        $stmt = $conn->prepare("DELETE FROM interventions WHERE id = ?");
        $stmt->execute([$id]);
        
        // Redirect back to interventions page with success message
        header("Location: interventions.php?deleted=1");
        exit();
    } else {
        // Redirect back to interventions page with error message
        header("Location: interventions.php?error=missing_id");
        exit();
    }
} catch(PDOException $e) {
    // Redirect back to interventions page with error message
    header("Location: interventions.php?error=db_error");
    exit();
}
?> 