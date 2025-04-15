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
    
    // Fetch user's interventions
    $stmt = $conn->prepare("
        SELECT i.*, s.name as student_name 
        FROM interventions i 
        JOIN students s ON i.student_id = s.id 
        WHERE i.created_by = ? 
        ORDER BY i.created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch user's students
    $stmt = $conn->prepare("
        SELECT * FROM students 
        WHERE created_by = ? 
        ORDER BY name
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Student Dropout Analysis System</title>
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
            <?php if (isset($error)): ?>
                <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-secondary rounded-lg p-6 shadow-lg">
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-32 h-32 rounded-full bg-accent/20 flex items-center justify-center mb-4">
                                <i class="fas fa-user text-5xl text-accent"></i>
                            </div>
                            <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($user['name']); ?></h2>
                            <p class="text-light"><?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
                        </div>
                        
                        <div class="border-t border-tertiary pt-4">
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-light mb-1">Email</h3>
                                <p><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-light mb-1">Member Since</h3>
                                <p><?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-light mb-1">Account Status</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="edit_profile.php" class="block w-full text-center bg-accent hover:bg-tertiary text-white font-medium py-2 px-4 rounded transition duration-300">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Section -->
                <div class="lg:col-span-2">
                    <div class="bg-secondary rounded-lg p-6 shadow-lg mb-6">
                        <h2 class="text-xl font-bold mb-4">My Activity</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-tertiary p-4 rounded-lg text-center stat-card">
                                <div class="text-3xl font-bold text-accent mb-1"><?php echo count($students); ?></div>
                                <div class="text-sm text-light">Students</div>
                            </div>
                            <div class="bg-tertiary p-4 rounded-lg text-center stat-card">
                                <div class="text-3xl font-bold text-accent mb-1"><?php echo count($interventions); ?></div>
                                <div class="text-sm text-light">Interventions</div>
                            </div>
                            <div class="bg-tertiary p-4 rounded-lg text-center stat-card">
                                <div class="text-3xl font-bold text-accent mb-1"><?php echo count(array_filter($students, function($s) { return $s['dropout_risk'] === 'high'; })); ?></div>
                                <div class="text-sm text-light">At-Risk Students</div>
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-semibold mb-3">Recent Interventions</h3>
                        <?php if (empty($interventions)): ?>
                            <p class="text-light">No interventions created yet.</p>
                        <?php else: ?>
                            <div class="space-y-3">
                                <?php foreach (array_slice($interventions, 0, 3) as $intervention): ?>
                                    <div class="bg-tertiary p-3 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium"><?php echo htmlspecialchars($intervention['student_name']); ?></h4>
                                                <p class="text-sm text-light"><?php echo htmlspecialchars($intervention['description']); ?></p>
                                            </div>
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                <?php echo $intervention['status'] === 'active' ? 'bg-green-500/20 text-green-500' : 'bg-gray-500/20 text-gray-500'; ?>">
                                                <?php echo ucfirst(htmlspecialchars($intervention['status'])); ?>
                                            </span>
                                        </div>
                                        <div class="text-xs text-light mt-2">
                                            <i class="far fa-calendar mr-1"></i>
                                            <?php echo date('M d, Y', strtotime($intervention['created_at'])); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($interventions) > 3): ?>
                                <div class="mt-4 text-center">
                                    <a href="interventions.php" class="text-accent hover:text-light">View all interventions</a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="bg-secondary rounded-lg p-6 shadow-lg">
                        <h2 class="text-xl font-bold mb-4">My Students</h2>
                        <?php if (empty($students)): ?>
                            <p class="text-light">No students added yet.</p>
                        <?php else: ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="border-b border-tertiary">
                                            <th class="text-left py-2 px-4 text-light">Name</th>
                                            <th class="text-left py-2 px-4 text-light">Grade</th>
                                            <th class="text-left py-2 px-4 text-light">Risk Level</th>
                                            <th class="text-left py-2 px-4 text-light">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($students, 0, 5) as $student): ?>
                                            <tr class="border-b border-tertiary/30">
                                                <td class="py-2 px-4"><?php echo htmlspecialchars($student['name']); ?></td>
                                                <td class="py-2 px-4"><?php echo htmlspecialchars($student['grade_level']); ?></td>
                                                <td class="py-2 px-4">
                                                    <span class="px-2 py-1 rounded-full text-xs 
                                                        <?php echo $student['dropout_risk'] === 'high' ? 'bg-red-500/20 text-red-500' : 
                                                            ($student['dropout_risk'] === 'medium' ? 'bg-yellow-500/20 text-yellow-500' : 
                                                            'bg-green-500/20 text-green-500'); ?>">
                                                        <?php echo ucfirst(htmlspecialchars($student['dropout_risk'])); ?>
                                                    </span>
                                                </td>
                                                <td class="py-2 px-4">
                                                    <a href="student_details.php?id=<?php echo $student['id']; ?>" class="text-accent hover:text-light">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if (count($students) > 5): ?>
                                <div class="mt-4 text-center">
                                    <a href="students.php" class="text-accent hover:text-light">View all students</a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
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