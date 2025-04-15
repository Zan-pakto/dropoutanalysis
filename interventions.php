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
    
    // Fetch interventions with student information
    $stmt = $conn->query("
        SELECT i.*, s.name as student_name, s.grade_level 
        FROM interventions i 
        JOIN students s ON i.student_id = s.id 
        ORDER BY i.created_at DESC
    ");
    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
    $interventions = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interventions - Student Dropout Analysis System</title>
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
    <style>
        .hero-bg {
            background-image: linear-gradient(rgba(8, 20, 27, 0.8), rgba(8, 20, 27, 0.8)), 
                              url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .dropdown-menu {
            display: none;
        }
        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body class="bg-primary text-lighter font-sans">
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
                    <a href="interventions.php" class="text-white font-medium">Interventions</a>
                    <a href="about.php" class="text-light hover:text-white font-medium">About Us</a>
                    <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
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
                    <?php else: ?>
                        <div class="flex items-center space-x-4">
                            <a href="signin.php" class="text-accent hover:text-white font-medium">Sign In</a>
                            <a href="signup.php" class="bg-accent hover:bg-tertiary px-4 py-2 rounded font-medium">Sign Up</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Student Interventions</h1>
            <?php if(isset($_SESSION['user_id'])): ?>
            <a href="add_intervention.php" class="bg-accent hover:bg-tertiary text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> New Intervention
            </a>
            <?php endif; ?>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                Intervention created successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                Intervention deleted successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                Intervention updated successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <?php 
                    if ($_GET['error'] == 'missing_id') {
                        echo "Error: Missing intervention ID.";
                    } elseif ($_GET['error'] == 'db_error') {
                        echo "Database error occurred.";
                    } else {
                        echo "An error occurred.";
                    }
                ?>
            </div>
        <?php endif; ?>

        <!-- Interventions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($interventions as $intervention): ?>
            <div class="bg-secondary rounded-lg p-6 shadow-lg hover:shadow-xl transition duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($intervention['student_name']); ?></h3>
                        <p class="text-light">Grade <?php echo htmlspecialchars($intervention['grade_level']); ?></p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm 
                        <?php echo $intervention['status'] === 'active' ? 'bg-green-500/20 text-green-500' : 'bg-gray-500/20 text-gray-500'; ?>">
                        <?php echo ucfirst(htmlspecialchars($intervention['status'])); ?>
                    </span>
                </div>
                
                <p class="text-light mb-4"><?php echo htmlspecialchars($intervention['description']); ?></p>
                
                <div class="flex justify-between items-center text-sm text-light">
                    <div>
                        <i class="far fa-calendar mr-1"></i>
                        <?php echo date('M d, Y', strtotime($intervention['created_at'])); ?>
                    </div>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="flex space-x-2">
                        <a href="edit_intervention.php?id=<?php echo $intervention['id']; ?>" class="text-accent hover:text-light">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="delete_intervention.php?id=<?php echo $intervention['id']; ?>" class="text-red-500 hover:text-red-400" onclick="return confirm('Are you sure you want to delete this intervention?');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($interventions)): ?>
        <div class="text-center py-12">
            <i class="fas fa-clipboard-list text-4xl text-accent mb-4"></i>
            <p class="text-light">No interventions found. Start by adding a new intervention.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-8">
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