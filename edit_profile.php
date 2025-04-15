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
    
    // Fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        
        // Validate name
        if (empty($name)) {
            $errors[] = "Name is required";
        }
        
        // Validate email
        if (empty($email)) {
            $errors[] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        } else {
            // Check if email is already taken by another user
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $_SESSION['user_id']]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "Email is already taken";
            }
        }
        
        // If password change is requested
        if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
            // Verify current password
            if (empty($current_password)) {
                $errors[] = "Current password is required to change password";
            } elseif (!password_verify($current_password, $user['password'])) {
                $errors[] = "Current password is incorrect";
            }
            
            // Validate new password
            if (empty($new_password)) {
                $errors[] = "New password is required";
            } elseif (strlen($new_password) < 8) {
                $errors[] = "New password must be at least 8 characters";
            }
            
            // Confirm password match
            if ($new_password !== $confirm_password) {
                $errors[] = "Passwords do not match";
            }
        }
        
        // If no errors, update the profile
        if (empty($errors)) {
            try {
                // Start transaction
                $conn->beginTransaction();
                
                // Update basic info
                $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                $stmt->execute([$name, $email, $_SESSION['user_id']]);
                
                // Update password if provided
                if (!empty($new_password)) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->execute([$hashed_password, $_SESSION['user_id']]);
                }
                
                // Commit transaction
                $conn->commit();
                
                // Set success message
                $success = "Profile updated successfully";
                
                // Refresh user data
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                // Rollback transaction on error
                $conn->rollBack();
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
    
} catch(PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Student Dropout Analysis System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                fontFamily: {
                    sans: ['Space Grotesk', 'sans-serif'],
                },
                extend: {
                    colors: {
                        'primary': '#08141B',
                        'secondary': '#11212D',
                        'tertiary': '#233745',
                        'accent': '#4A5C6A',
                        'light': '#9BAAAB',
                        'lighter': '#CCD0CF',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-primary text-lighter font-sans min-h-screen flex flex-col">
    <!-- Navigation Bar -->
    <nav class="bg-secondary text-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-2xl text-accent mr-2"></i>
                    <span class="font-semibold text-xl tracking-tight">DROPOUT ANALYSIS</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-light hover:text-white font-medium">Home</a>
                    <a href="analysis.php" class="text-light hover:text-white font-medium">Analysis</a>
                    <a href="interventions.php" class="text-light hover:text-white font-medium">Interventions</a>
                    <a href="about.php" class="text-light hover:text-white font-medium">About Us</a>
                    <div class="relative">
                        <button id="profileDropdownBtn" class="flex items-center space-x-2 bg-accent hover:bg-tertiary px-4 py-2 rounded font-medium">
                            <i class="fas fa-user-circle"></i>
                            <span>Profile</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="profileDropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-secondary rounded-md shadow-lg py-2 z-10">
                            <a href="profile.php" class="block px-4 py-2 text-sm text-lighter hover:bg-tertiary">My Profile</a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-lighter hover:bg-tertiary">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="container mx-auto px-6 py-8">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center mb-6">
                    <a href="profile.php" class="text-accent hover:text-light mr-4">
                        <i class="fas fa-arrow-left"></i> Back to Profile
                    </a>
                    <h1 class="text-2xl font-bold">Edit Profile</h1>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($errors)): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="bg-secondary rounded-lg p-6 shadow-lg">
                    <form method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required
                                   class="w-full px-4 py-2 rounded bg-tertiary border border-accent focus:outline-none focus:border-accent">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                                   class="w-full px-4 py-2 rounded bg-tertiary border border-accent focus:outline-none focus:border-accent">
                        </div>
                        
                        <div class="border-t border-tertiary pt-6">
                            <h3 class="text-lg font-semibold mb-4">Change Password</h3>
                            <p class="text-sm text-light mb-4">Leave these fields blank if you don't want to change your password.</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium mb-2">Current Password</label>
                                    <input type="password" id="current_password" name="current_password"
                                           class="w-full px-4 py-2 rounded bg-tertiary border border-accent focus:outline-none focus:border-accent">
                                </div>
                                
                                <div>
                                    <label for="new_password" class="block text-sm font-medium mb-2">New Password</label>
                                    <input type="password" id="new_password" name="new_password"
                                           class="w-full px-4 py-2 rounded bg-tertiary border border-accent focus:outline-none focus:border-accent">
                                </div>
                                
                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium mb-2">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                           class="w-full px-4 py-2 rounded bg-tertiary border border-accent focus:outline-none focus:border-accent">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between pt-4">
                            <a href="profile.php" class="bg-tertiary hover:bg-accent text-white font-medium py-2 px-4 rounded transition duration-300">
                                Cancel
                            </a>
                            <button type="submit" class="bg-accent hover:bg-tertiary text-white font-medium py-2 px-4 rounded transition duration-300">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-8 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p class="text-light">© <?= date('Y') ?> Student Dropout Analysis System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Profile dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownBtn = document.getElementById('profileDropdownBtn');
            const dropdownMenu = document.getElementById('profileDropdownMenu');
            
            if (dropdownBtn && dropdownMenu) {
                // Toggle dropdown on button click
                dropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                    }
                });
                
                // Prevent dropdown from closing when clicking inside it
                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>
</html> 