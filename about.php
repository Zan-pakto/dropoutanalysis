<?php
session_start();

// Include authentication check
require_once 'includes/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Student Dropout Analysis System</title>
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
                    <a href="interventions.php" class="text-light hover:text-white font-medium">Interventions</a>
                    <a href="about.php" class="text-white font-medium">About Us</a>
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
    <div class="container mx-auto px-6 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold mb-4">About Our Mission</h1>
            <p class="text-light max-w-2xl mx-auto">
                We are dedicated to helping educational institutions identify and support students at risk of dropping out,
                ensuring every student has the opportunity to succeed in their academic journey.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-secondary p-6 rounded-lg">
                <div class="text-accent text-3xl mb-4">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Data-Driven Analysis</h3>
                <p class="text-light">
                    Advanced algorithms analyze student data to identify early warning signs and predict dropout risks.
                </p>
            </div>
            
            <div class="bg-secondary p-6 rounded-lg">
                <div class="text-accent text-3xl mb-4">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Targeted Interventions</h3>
                <p class="text-light">
                    Customized intervention strategies to address specific challenges faced by at-risk students.
                </p>
            </div>
            
            <div class="bg-secondary p-6 rounded-lg">
                <div class="text-accent text-3xl mb-4">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Student Success</h3>
                <p class="text-light">
                    Comprehensive support system to help students overcome obstacles and achieve academic success.
                </p>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-8">Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-accent"></i>
                    </div>
                    <h3 class="font-semibold">John Doe</h3>
                    <p class="text-light">Project Lead</p>
                </div>
                
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-accent"></i>
                    </div>
                    <h3 class="font-semibold">Jane Smith</h3>
                    <p class="text-light">Data Analyst</p>
                </div>
                
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-accent"></i>
                    </div>
                    <h3 class="font-semibold">Mike Johnson</h3>
                    <p class="text-light">Education Specialist</p>
                </div>
                
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-accent"></i>
                    </div>
                    <h3 class="font-semibold">Sarah Williams</h3>
                    <p class="text-light">Technical Lead</p>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-secondary rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Get in Touch</h2>
            <p class="text-light mb-6">
                Have questions about our system? We'd love to hear from you.
            </p>
            <a href="mailto:contact@dropoutanalysis.com" 
               class="inline-flex items-center bg-accent hover:bg-tertiary text-white px-6 py-3 rounded-lg">
                <i class="fas fa-envelope mr-2"></i>
                Contact Us
            </a>
        </div>
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