<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'dropout_analysis';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            
            // Check if there's a redirect URL
            $redirect = $_POST['redirect'] ?? 'index.php';
            header('Location: ' . $redirect);
            exit();
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Please fill in all fields";
    }
}

// Get redirect URL from query parameter if available
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Student Dropout Analysis System</title>
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
    <main class="flex-grow flex items-center justify-center py-12">
        <div class="max-w-md w-full mx-4">
            <div class="bg-secondary p-8 rounded-lg shadow-xl">
                <div class="text-center mb-8">
                    <i class="fas fa-graduation-cap text-4xl text-accent mb-4"></i>
                    <h2 class="text-2xl font-bold">Welcome Back</h2>
                    <p class="text-light mt-2">Sign in to access your dashboard</p>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6" id="signinForm">
                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                    
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-2 rounded bg-tertiary border border-accent focus:outline-none focus:border-accent">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-2 rounded bg-tertiary border border-accent focus:outline-none focus:border-accent">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" class="rounded bg-tertiary border-accent text-accent focus:ring-accent">
                            <label for="remember" class="ml-2 text-sm">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-accent hover:text-light">Forgot password?</a>
                    </div>

                    <button type="submit" 
                            class="w-full bg-accent hover:bg-tertiary text-white font-medium py-2 px-4 rounded transition duration-300">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-light">
                        Don't have an account? 
                        <a href="signup.php" class="text-accent hover:text-light">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-secondary shadow-lg mt-auto">
        <div class="container mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-light text-sm">
                &copy; <?php echo date('Y'); ?> Dropout Prevention System. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Authentication Modal -->
    <?php include 'includes/auth_modal.php'; ?>

    <script>
        // Form validation
        document.getElementById('signinForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all fields');
            }
        });
    </script>
</body>
</html> 