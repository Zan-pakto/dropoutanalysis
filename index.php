<?php
// Initialize session
session_start();

// Database connection for dynamic stats
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'dropout_analysis';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch statistics
    $stmt = $conn->query("SELECT 
        (SELECT COUNT(*) FROM students) AS total_students,
        (SELECT COUNT(*) FROM students WHERE dropout_risk = 'high') AS at_risk,
        (SELECT COUNT(*) FROM interventions) AS interventions");
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Use default stats if DB connection fails
    $stats = [
        'total_students' => 2400,
        'at_risk' => 460,
        'interventions' => 300
    ];
}

require_once 'includes/header.php';
?>

<!-- Hero Section with Background Image -->
<section class="hero-bg text-white py-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight">Turning Dropouts into Comebacks</h1>
        <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto text-light leading-relaxed">
            "Dropouts aren't numbers; they're stories unwritten, talents untapped, and hopes unfulfilled."
        </p>
        <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="signin.php" class="bg-accent hover:bg-tertiary text-white font-bold py-3 px-8 rounded-lg inline-block transition duration-300 tracking-wide">
                Sign In
            </a>
            <a href="signup.php" class="bg-transparent border-2 border-accent text-white font-bold py-3 px-8 rounded-lg inline-block transition duration-300 tracking-wide hover:bg-accent/20">
                Sign Up
            </a>
        </div>
        <?php else: ?>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="interventions.php" class="bg-accent hover:bg-tertiary text-white font-bold py-3 px-8 rounded-lg inline-block transition duration-300 tracking-wide">
                View Interventions
            </a>
            <a href="students.php" class="bg-transparent border-2 border-accent text-white font-bold py-3 px-8 rounded-lg inline-block transition duration-300 tracking-wide hover:bg-accent/20">
                Manage Students
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-secondary text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4 tracking-tight">System Overview</h2>
            <div class="w-24 h-1 bg-accent mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="stat-card bg-tertiary p-6 rounded-lg">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-user-graduate text-4xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 tracking-tight">Total Students</h3>
                <p class="text-3xl font-bold text-accent"><?php echo number_format($stats['total_students']); ?></p>
                <p class="text-light text-sm mt-2">Students in the system</p>
            </div>
            <div class="stat-card bg-tertiary p-6 rounded-lg">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-4xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 tracking-tight">At-Risk Students</h3>
                <p class="text-3xl font-bold text-accent"><?php echo number_format($stats['at_risk']); ?></p>
                <p class="text-light text-sm mt-2">Students identified as high risk</p>
            </div>
            <div class="stat-card bg-tertiary p-6 rounded-lg">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-hands-helping text-4xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 tracking-tight">Active Interventions</h3>
                <p class="text-3xl font-bold text-accent"><?php echo number_format($stats['interventions']); ?></p>
                <p class="text-light text-sm mt-2">Support programs in progress</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4 tracking-tight">How It Works</h2>
            <div class="w-24 h-1 bg-accent mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-secondary p-6 rounded-lg">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-4xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 tracking-tight">Identify Risk Factors</h3>
                <p class="text-light leading-relaxed">
                    Our system analyzes academic performance, attendance, and behavioral data to identify students at risk of dropping out.
                </p>
            </div>
            <div class="bg-secondary p-6 rounded-lg">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-clipboard-list text-4xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 tracking-tight">Create Interventions</h3>
                <p class="text-light leading-relaxed">
                    Develop targeted support programs based on individual student needs and risk factors.
                </p>
            </div>
            <div class="bg-secondary p-6 rounded-lg">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-chart-bar text-4xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 tracking-tight">Track Progress</h3>
                <p class="text-light leading-relaxed">
                    Monitor the effectiveness of interventions and adjust strategies to improve student outcomes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 bg-secondary text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4 tracking-tight">Success Stories</h2>
            <div class="w-24 h-1 bg-accent mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-tertiary p-6 rounded-lg">
                <div class="flex items-start mb-4">
                    <div class="w-16 h-16 rounded-full bg-accent/20 flex items-center justify-center mr-4">
                        <i class="fas fa-user text-2xl text-accent"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold tracking-tight">Rahul Sharma</h3>
                        <p class="text-light">Former At-Risk Student</p>
                    </div>
                </div>
                <p class="text-lighter italic">"The intervention program helped me overcome my academic challenges. I'm now pursuing my dream career in engineering."</p>
            </div>
            <div class="bg-tertiary p-6 rounded-lg">
                <div class="flex items-start mb-4">
                    <div class="w-16 h-16 rounded-full bg-accent/20 flex items-center justify-center mr-4">
                        <i class="fas fa-user text-2xl text-accent"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold tracking-tight">Priya Patel</h3>
                        <p class="text-light">School Counselor</p>
                    </div>
                </div>
                <p class="text-lighter italic">"This system has transformed how we identify and support at-risk students. Our dropout rate has decreased by 35% in just one year."</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-6 tracking-tight">Ready to Make a Difference?</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto text-light leading-relaxed">
            Join our mission to prevent student dropouts and create brighter futures for all students.
        </p>
        <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="signup.php" class="bg-accent hover:bg-tertiary text-white font-bold py-3 px-8 rounded-lg inline-block transition duration-300 tracking-wide">
            Get Started Today
        </a>
        <?php else: ?>
        <a href="students.php" class="bg-accent hover:bg-tertiary text-white font-bold py-3 px-8 rounded-lg inline-block transition duration-300 tracking-wide">
            Manage Students
        </a>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<!-- Authentication Modal -->
<?php include 'includes/auth_modal.php'; ?>

<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Show auth modal if redirected from a restricted page
    <?php if(isset($_GET['auth_required']) && $_GET['auth_required'] == 1): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showAuthModal();
    });
    <?php endif; ?>
</script>
</body>
</html>