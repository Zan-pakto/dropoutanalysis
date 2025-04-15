<!-- Authentication Modal -->
<div id="authModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-secondary rounded-lg p-8 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Authentication Required</h3>
            <button id="closeAuthModal" class="text-light hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p class="text-light mb-6">Please sign in or create an account to access this feature.</p>
        <div class="flex flex-col space-y-4">
            <a href="signin.php" class="bg-accent hover:bg-tertiary text-white text-center py-3 px-4 rounded font-medium">
                Sign In
            </a>
            <a href="signup.php" class="bg-tertiary hover:bg-accent text-white text-center py-3 px-4 rounded font-medium">
                Sign Up
            </a>
        </div>
    </div>
</div>

<script>
    // Function to show the auth modal
    function showAuthModal() {
        document.getElementById('authModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    // Function to hide the auth modal
    function hideAuthModal() {
        document.getElementById('authModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close modal when clicking the close button
    document.getElementById('closeAuthModal').addEventListener('click', hideAuthModal);
    
    // Close modal when clicking outside
    document.getElementById('authModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideAuthModal();
        }
    });
    
    // Intercept clicks on restricted navigation links
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])): ?>
            // Get all navigation links except home
            const navLinks = document.querySelectorAll('nav a[href="analysis.php"], nav a[href="interventions.php"], nav a[href="about.php"], nav a[href="profile.php"]');
            
            // Add click event listener to each link
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showAuthModal();
                });
            });
        <?php endif; ?>
    });
</script> 