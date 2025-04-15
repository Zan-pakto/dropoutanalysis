<?php
// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to home page with a parameter to show the auth modal
    header('Location: index.php?auth_required=1');
    exit();
}
?> 