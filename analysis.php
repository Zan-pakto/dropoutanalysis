<?php
session_start();

// Include authentication check
require_once 'includes/auth_check.php';

// State data with your provided information
$states = [
    'Odisha' => [
        'dropout_rates' => [
            'primary' => 0.8,
            'upper_primary' => 4.5,
            'secondary' => 23.6,
            'secondary_high' => 28.3,
            'girls_secondary' => 25.8,
            'boys_secondary' => 21.4
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 35],
            ['name' => 'Domestic Responsibilities', 'percentage' => 25],
            ['name' => 'Lack of Interest', 'percentage' => 20],
            ['name' => 'Distance to School', 'percentage' => 15],
            ['name' => 'Safety Concerns', 'percentage' => 5]
        ],
        'strategies' => [
            'Financial Assistance',
            'Community Engagement',
            'Curriculum Enhancement',
            'Infrastructure Development',
            'Safety Measures'
        ],
        'image' => 'img/odishamap.png'
    ],
    'Bihar' => [
        'dropout_rates' => [
            'primary' => 2.3,
            'upper_primary' => 8.9,
            'secondary' => 21.4,
            'girls_secondary' => 24.6,
            'boys_secondary' => 18.2
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 40],
            ['name' => 'Gender Inequality', 'percentage' => 25],
            ['name' => 'Child Marriage', 'percentage' => 15],
            ['name' => 'Infrastructure Deficiencies', 'percentage' => 15],
            ['name' => 'Cultural Expectations', 'percentage' => 5]
        ],
        'strategies' => [
            'Financial Support',
            'Community Awareness',
            'Infrastructure Enhancement',
            'Policy Interventions',
            'Vocational Training'
        ],
        'image' => 'img/bihar.png'
    ],
    'Assam' => [
        'dropout_rates' => [
            'lower_primary' => 4.3,
            'upper_primary' => 3.4,
            'secondary' => 32.3,
            'girls_secondary' => 35.8,
            'boys_secondary' => 28.8
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 30],
            ['name' => 'Gender Inequality', 'percentage' => 25],
            ['name' => 'Infrastructure Gaps', 'percentage' => 20],
            ['name' => 'Transportation', 'percentage' => 15],
            ['name' => 'Lack of Interest', 'percentage' => 10]
        ],
        'strategies' => [
            'Financial Support',
            'Community Awareness',
            'School Infrastructure',
            'Transport Facilities',
            'Curriculum Revitalization'
        ],
        'image' => 'img/assam.png'
    ],
    'Gujarat' => [
        'dropout_rates' => [
            'primary' => 1.0,
            'upper_primary' => 5.2,
            'secondary' => 23.7,
            'chhota_udaipur' => 42.5,
            'girls_secondary' => 26.3,
            'boys_secondary' => 21.1
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 35],
            ['name' => 'Gender Disparities', 'percentage' => 25],
            ['name' => 'Quality of Education', 'percentage' => 20],
            ['name' => 'Infrastructure', 'percentage' => 15],
            ['name' => 'Social Factors', 'percentage' => 5]
        ],
        'strategies' => [
            'Financial Assistance',
            'Community Engagement',
            'Curriculum Enhancement',
            'Infrastructure Development',
            'Girls Education Programs'
        ],
        'image' => 'img/guju.png'
    ],
    'Karnataka' => [
        'dropout_rates' => [
            'primary' => 1.2,
            'upper_primary' => 2.5,
            'secondary' => 16.8,
            'girls_secondary' => 18.9,
            'boys_secondary' => 14.7
        ],
        'causes' => [
            ['name' => 'Migration', 'percentage' => 30],
            ['name' => 'Economic Constraints', 'percentage' => 25],
            ['name' => 'Gender Disparities', 'percentage' => 20],
            ['name' => 'Quality of Education', 'percentage' => 15],
            ['name' => 'Infrastructure', 'percentage' => 10]
        ],
        'strategies' => [
            'Financial Assistance',
            'Community Engagement',
            'Curriculum Enhancement',
            'Infrastructure Development',
            'Migration Support'
        ],
        'image' => 'img/karna.png'
    ],
    'Maharashtra' => [
        'dropout_rates' => [
            'primary' => 0.0,
            'upper_primary' => 1.1,
            'secondary' => 15.2,
            'girls_secondary' => 16.8,
            'boys_secondary' => 13.6
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 30],
            ['name' => 'Migration', 'percentage' => 25],
            ['name' => 'Quality of Education', 'percentage' => 20],
            ['name' => 'Infrastructure', 'percentage' => 15],
            ['name' => 'Social Factors', 'percentage' => 10]
        ],
        'strategies' => [
            'Financial Assistance',
            'Community Engagement',
            'Curriculum Enhancement',
            'Infrastructure Development',
            'Migration Support'
        ],
        'image' => 'img/maharashtra.png'
    ],
    'Tamil Nadu' => [
        'dropout_rates' => [
            'primary' => 1.1,
            'upper_primary' => 0.4,
            'secondary' => 9.6,
            'girls_secondary' => 10.2,
            'boys_secondary' => 9.0
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 35],
            ['name' => 'Gender Disparities', 'percentage' => 20],
            ['name' => 'Quality of Education', 'percentage' => 20],
            ['name' => 'Infrastructure', 'percentage' => 15],
            ['name' => 'Social Factors', 'percentage' => 10]
        ],
        'strategies' => [
            'Financial Assistance',
            'Community Engagement',
            'Curriculum Enhancement',
            'Infrastructure Development',
            'Girls Education Programs'
        ],
        'image' => 'img/tamilnadu.png'
    ],
    'Uttar Pradesh' => [
        'dropout_rates' => [
            'primary' => 2.7,
            'upper_primary' => 2.1,
            'secondary' => 14.4,
            'girls_secondary' => 16.8,
            'boys_secondary' => 12.0
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 40],
            ['name' => 'Gender Inequality', 'percentage' => 25],
            ['name' => 'Child Marriage', 'percentage' => 15],
            ['name' => 'Infrastructure Deficiencies', 'percentage' => 15],
            ['name' => 'Cultural Expectations', 'percentage' => 5]
        ],
        'strategies' => [
            'Financial Support',
            'Community Awareness',
            'Infrastructure Enhancement',
            'Policy Interventions',
            'Vocational Training'
        ],
        'image' => 'img/up.png'
    ],
    'Rajasthan' => [
        'dropout_rates' => [
            'primary' => 2.9,
            'upper_primary' => 1.5,
            'secondary' => 12.3,
            'girls_secondary' => 14.5,
            'boys_secondary' => 10.1
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 35],
            ['name' => 'Gender Inequality', 'percentage' => 30],
            ['name' => 'Child Marriage', 'percentage' => 15],
            ['name' => 'Infrastructure Deficiencies', 'percentage' => 15],
            ['name' => 'Cultural Expectations', 'percentage' => 5]
        ],
        'strategies' => [
            'Financial Support',
            'Community Awareness',
            'Infrastructure Enhancement',
            'Policy Interventions',
            'Girls Education Programs'
        ],
        'image' => 'img/rajasthan.png'
    ],
    'Madhya Pradesh' => [
        'dropout_rates' => [
            'primary' => 0.8,
            'upper_primary' => 4.1,
            'secondary' => 23.2,
            'girls_secondary' => 25.8,
            'boys_secondary' => 20.6
        ],
        'causes' => [
            ['name' => 'Economic Constraints', 'percentage' => 35],
            ['name' => 'Gender Inequality', 'percentage' => 25],
            ['name' => 'Child Marriage', 'percentage' => 15],
            ['name' => 'Infrastructure Deficiencies', 'percentage' => 15],
            ['name' => 'Cultural Expectations', 'percentage' => 10]
        ],
        'strategies' => [
            'Financial Support',
            'Community Awareness',
            'Infrastructure Enhancement',
            'Policy Interventions',
            'Girls Education Programs'
        ],
        'image' => 'img/mp.png'
    ]
];

// Calculate national averages for pie chart
$nationalAverages = [
    'primary' => 0,
    'upper_primary' => 0,
    'secondary' => 0
];

$stateCount = count($states);
foreach ($states as $state => $data) {
    $nationalAverages['primary'] += $data['dropout_rates']['primary'] ?? $data['dropout_rates']['lower_primary'] ?? 0;
    $nationalAverages['upper_primary'] += $data['dropout_rates']['upper_primary'] ?? 0;
    $nationalAverages['secondary'] += $data['dropout_rates']['secondary'] ?? 0;
}

$nationalAverages['primary'] = round($nationalAverages['primary'] / $stateCount, 1);
$nationalAverages['upper_primary'] = round($nationalAverages['upper_primary'] / $stateCount, 1);
$nationalAverages['secondary'] = round($nationalAverages['secondary'] / $stateCount, 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State Dropout Analysis | Indian States</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-8px)' },
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .state-card {
            transition: all 0.3s ease;
            background-size: cover;
            background-position: center;
            height: 200px;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
        }
        .state-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(24, 54, 71, 0.9), rgba(29, 64, 83, 0.5));
        }
        .state-card .content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            transform: translateY(100px);
            transition: transform 0.3s ease;
        }
        .state-card:hover .content {
            transform: translateY(0);
        }
        .state-card h3 {
            transition: all 0.3s ease;
        }
        .state-card:hover h3 {
            margin-bottom: 0.5rem;
        }
        .states-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }
        .state-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
            overflow-y: auto;
            padding: 2rem;
        }
        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 1200px;
            margin: 2rem auto;
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            color: white;
            cursor: pointer;
        }
        /* Key Statistics Section Styles */
        .stats-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .stats-title {
            font-weight: 600;
            color: #11212D;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #4A5C6A;
            padding-bottom: 0.75rem;
        }
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            height: 100%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .findings-container {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .hero-bg {
            background-image: linear-gradient(rgba(8, 20, 27, 0.8), rgba(8, 20, 27, 0.8)), 
                              url('https://images.unsplash.com/flagged/photo-1574097656146-0b43b7660cb6?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
        }
        .dropdown-menu {
            display: none;
        }
        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body class="bg-lighter font-sans">
    <!-- Navigation -->
    <nav class="bg-primary text-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-2xl text-accent mr-2"></i>
                    <span class="font-semibold text-xl">State Dropout Analysis</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-light hover:text-white font-medium">Home</a>
                    <a href="analysis.php" class="text-white font-medium">Analysis</a>
                    <a href="interventions.php" class="text-light hover:text-white font-medium">Interventions</a>
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
                <button class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold text-center text-primary mb-4">State-Wise Dropout Analysis</h1>
        <p class="text-xl text-center text-secondary mb-12">Exploring dropout rates across Indian states</p>
        
        <!-- National Overview -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-16">
            <h2 class="text-2xl font-bold text-primary mb-6">National Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="h-80">
                    <canvas id="nationalPieChart"></canvas>
                </div>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-secondary mb-2">Primary Education (1-5)</h3>
                        <p class="text-gray-700">Average dropout rate: <?= $nationalAverages['primary'] ?>%</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-secondary mb-2">Upper Primary (6-8)</h3>
                        <p class="text-gray-700">Average dropout rate: <?= $nationalAverages['upper_primary'] ?>%</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-secondary mb-2">Secondary (9-10)</h3>
                        <p class="text-gray-700">Average dropout rate: <?= $nationalAverages['secondary'] ?>%</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- State Cards Grid -->
        <div class="states-grid mb-16">
            <?php 
            // Reorder states to show all states
            $orderedStates = [
                'Odisha' => $states['Odisha'],
                'Bihar' => $states['Bihar'],
                'Uttar Pradesh' => $states['Uttar Pradesh'],
                'Rajasthan' => $states['Rajasthan'],
                'Madhya Pradesh' => $states['Madhya Pradesh'],
                'Gujarat' => $states['Gujarat'],
                'Karnataka' => $states['Karnataka'],
                'Maharashtra' => $states['Maharashtra'],
                'Tamil Nadu' => $states['Tamil Nadu'],
                'Assam' => $states['Assam']
            ];
            
            foreach ($orderedStates as $state => $data): ?>
                <div class="state-card w-80 cursor-pointer" 
                     style="background-image: url('<?= $data['image'] ?>')"
                     onclick="openStateModal('<?= strtolower($state) ?>')">
                    <div class="content text-white">
                        <h3 class="text-2xl font-bold mb-8"><?= $state ?></h3>
                        <div class="opacity-0 transition-opacity duration-300 state-card:hover:opacity-100">
                            <p class="mb-2"><strong>Secondary Dropout:</strong> <?= $data['dropout_rates']['secondary'] ?>%</p>
                            <p class="mb-4"><?= $state == 'Odisha' ? 'Highest in India' : ($state == 'Assam' ? 'Exceeds national average' : 'Significant challenge') ?></p>
                            <button class="inline-block bg-accent hover:bg-tertiary text-white font-medium py-2 px-4 rounded">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- State Modals -->
        <?php foreach ($states as $state => $data): ?>
            <div id="<?= strtolower($state) ?>-modal" class="state-modal">
                <span class="close-modal" onclick="closeModal('<?= strtolower($state) ?>-modal')">&times;</span>
                
                <div class="modal-content">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <!-- State Header -->
                        <div class="bg-secondary text-white p-8">
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="md:w-1/3 mb-6 md:mb-0">
                                    <div class="h-48 w-full rounded-lg overflow-hidden shadow-md">
                                        <img src="<?= $data['image'] ?>" alt="<?= $state ?>" class="h-full w-full object-cover">
                                    </div>
                                </div>
                                <div class="md:w-2/3 md:pl-8">
                                    <h2 class="text-3xl font-bold mb-2"><?= $state ?> Dropout Analysis</h2>
                                    <p class="text-light mb-6">Comprehensive data and insights about student dropout trends in <?= $state ?></p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        <div class="bg-tertiary p-3 rounded-lg">
                                            <div class="text-xl font-bold">
                                                <?= $data['dropout_rates']['primary'] ?? $data['dropout_rates']['lower_primary'] ?? 'N/A' ?>%
                                            </div>
                                            <div class="text-xs text-light">Primary</div>
                                        </div>
                                        <div class="bg-tertiary p-3 rounded-lg">
                                            <div class="text-xl font-bold">
                                                <?= $data['dropout_rates']['upper_primary'] ?>%
                                            </div>
                                            <div class="text-xs text-light">Upper Primary</div>
                                        </div>
                                        <div class="bg-tertiary p-3 rounded-lg">
                                            <div class="text-xl font-bold">
                                                <?= $data['dropout_rates']['secondary'] ?>%
                                            </div>
                                            <div class="text-xs text-light">Secondary</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Content -->
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Dropout Distribution Pie Chart -->
                                <div class="bg-white p-6 rounded-lg shadow-lg">
                                    <h4 class="text-xl font-semibold text-secondary mb-4">Dropout Distribution</h4>
                                    <div class="h-64">
                                        <canvas id="<?= strtolower($state) ?>-pie-chart"></canvas>
                                    </div>
                                </div>
                                <!-- Gender-wise Dropout Rates -->
                                <div class="bg-white p-6 rounded-lg shadow-lg">
                                    <h4 class="text-xl font-semibold text-secondary mb-4">Gender-wise Analysis</h4>
                                    <div class="h-64">
                                        <canvas id="<?= strtolower($state) ?>-gender-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Causes Chart -->
                                <div class="bg-white p-6 rounded-lg shadow-lg">
                                    <h4 class="text-xl font-semibold text-secondary mb-4">Primary Causes</h4>
                                    <div class="h-64">
                                        <canvas id="<?= strtolower($state) ?>CausesChart"></canvas>
                                    </div>
                                </div>
                                <!-- Strategies Chart -->
                                <div class="bg-white p-6 rounded-lg shadow-lg">
                                    <h4 class="text-xl font-semibold text-secondary mb-4">Recommended Strategies</h4>
                                    <div class="h-64">
                                        <canvas id="<?= strtolower($state) ?>StrategiesChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Key Statistics - UPDATED SECTION -->
                            <div class="stats-section">
                                <h3 class="stats-title">Key Statistics</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="findings-container">
                                        <h4 class="text-xl font-semibold text-secondary mb-4">Notable Findings</h4>
                                        <ul class="space-y-3 text-gray-700">
                                            <?php if($state == 'Odisha'): ?>
                                                <li class="flex items-start">
                                                    <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-2"></i>
                                                    <span>Highest secondary dropout rate in India at <?= $data['dropout_rates']['secondary'] ?>% (govt data) or <?= $data['dropout_rates']['secondary_high'] ?>% (other reports)</span>
                                                </li>
                                            <?php elseif($state == 'Bihar'): ?>
                                                <li class="flex items-start">
                                                    <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-2"></i>
                                                    <span>Upper primary dropout rate of <?= $data['dropout_rates']['upper_primary'] ?>%, far exceeding national average</span>
                                                </li>
                                            <?php elseif($state == 'Assam'): ?>
                                                <li class="flex items-start">
                                                    <i class="fas fa-arrow-up text-red-500 mt-1 mr-2"></i>
                                                    <span>Increasing dropout rates across all levels (<?= $data['dropout_rates']['lower_primary'] ?>% to <?= $data['dropout_rates']['secondary'] ?>%)</span>
                                                </li>
                                            <?php elseif($state == 'Gujarat'): ?>
                                                <li class="flex items-start">
                                                    <i class="fas fa-female text-purple-500 mt-1 mr-2"></i>
                                                    <span>Chhota Udaipur district has <?= $data['dropout_rates']['chhota_udaipur'] ?>% girl dropout rate</span>
                                                </li>
                                            <?php elseif($state == 'Karnataka'): ?>
                                                <li class="flex items-start">
                                                    <i class="fas fa-chart-line text-red-500 mt-1 mr-2"></i>
                                                    <span>Secondary dropout rate increased from 14.9% to <?= $data['dropout_rates']['secondary'] ?>% in one year</span>
                                                </li>
                                            <?php endif; ?>
                                            <li class="flex items-start">
                                                <i class="fas fa-venus-mars text-blue-500 mt-1 mr-2"></i>
                                                <span>
                                                    <?php if(isset($data['dropout_rates']['girls_secondary'])): ?>
                                                        Girls complete secondary at <?= $data['dropout_rates']['girls_secondary'] ?>% vs boys at <?= $data['dropout_rates']['boys_secondary'] ?>%
                                                    <?php else: ?>
                                                        Significant gender disparities in education completion
                                                    <?php endif; ?>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p class="text-light">© <?= date('Y') ?> Student Dropout Analysis System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Store chart instances
        const chartInstances = {};

        // Initialize national pie chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('nationalPieChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Primary (1-5)', 'Upper Primary (6-8)', 'Secondary (9-10)'],
                    datasets: [{
                        data: [
                            <?= $nationalAverages['primary'] ?>,
                            <?= $nationalAverages['upper_primary'] ?>,
                            <?= $nationalAverages['secondary'] ?>
                        ],
                        backgroundColor: [
                            'rgba(74, 92, 106, 0.7)',
                            'rgba(35, 55, 69, 0.7)',
                            'rgba(8, 20, 27, 0.7)'
                        ],
                        borderColor: [
                            'rgba(74, 92, 106, 1)',
                            'rgba(35, 55, 69, 1)',
                            'rgba(8, 20, 27, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'National Average Dropout Rates',
                            font: {
                                family: 'Space Grotesk',
                                size: 16,
                                weight: '600'
                            }
                        },
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: 'Space Grotesk'
                                }
                            }
                        }
                    }
                }
            });
        });

        // Function to initialize charts for a state
        function initializeCharts(state, data) {
            const stateLower = state.toLowerCase();
            
            // Dropout Distribution Pie Chart
            if (chartInstances[stateLower + 'Pie']) {
                chartInstances[stateLower + 'Pie'].destroy();
            }
            chartInstances[stateLower + 'Pie'] = new Chart(
                document.getElementById(stateLower + '-pie-chart').getContext('2d'),
                {
                    type: 'pie',
                    data: {
                        labels: ['Primary (1-5)', 'Upper Primary (6-8)', 'Secondary (9-10)'],
                        datasets: [{
                            data: [
                                data.dropout_rates.primary ?? data.dropout_rates.lower_primary ?? 0,
                                data.dropout_rates.upper_primary ?? 0,
                                data.dropout_rates.secondary ?? 0
                            ],
                            backgroundColor: [
                                'rgba(74, 92, 106, 0.7)',
                                'rgba(35, 55, 69, 0.7)',
                                'rgba(8, 20, 27, 0.7)'
                            ],
                            borderColor: [
                                'rgba(74, 92, 106, 1)',
                                'rgba(35, 55, 69, 1)',
                                'rgba(8, 20, 27, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Dropout Distribution by Education Level',
                                font: {
                                    family: 'Space Grotesk',
                                    size: 16,
                                    weight: '600'
                                }
                            },
                            legend: {
                                position: 'right',
                                labels: {
                                    font: {
                                        family: 'Space Grotesk'
                                    }
                                }
                            }
                        }
                    }
                }
            );

            // Gender-wise Dropout Chart
            if (chartInstances[stateLower + 'Gender']) {
                chartInstances[stateLower + 'Gender'].destroy();
            }
            chartInstances[stateLower + 'Gender'] = new Chart(
                document.getElementById(stateLower + '-gender-chart').getContext('2d'),
                {
                    type: 'bar',
                    data: {
                        labels: ['Boys', 'Girls'],
                        datasets: [{
                            label: 'Secondary Dropout Rate (%)',
                            data: [
                                data.dropout_rates.boys_secondary ?? 0,
                                data.dropout_rates.girls_secondary ?? 0
                            ],
                            backgroundColor: [
                                'rgba(74, 92, 106, 0.7)',
                                'rgba(155, 170, 171, 0.7)'
                            ],
                            borderColor: [
                                'rgba(74, 92, 106, 1)',
                                'rgba(155, 170, 171, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Gender-wise Dropout Rates',
                                font: {
                                    family: 'Space Grotesk',
                                    size: 16,
                                    weight: '600'
                                }
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Dropout Rate (%)',
                                    font: {
                                        family: 'Space Grotesk',
                                        weight: '600'
                                    }
                                },
                                ticks: {
                                    font: {
                                        family: 'Space Grotesk'
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        family: 'Space Grotesk'
                                    }
                                }
                            }
                        }
                    }
                }
            );

            // Causes Chart
            if (chartInstances[stateLower + 'Causes']) {
                chartInstances[stateLower + 'Causes'].destroy();
            }
            chartInstances[stateLower + 'Causes'] = new Chart(
                document.getElementById(stateLower + 'CausesChart').getContext('2d'),
                {
                    type: 'doughnut',
                    data: {
                        labels: data.causes.map(cause => cause.name),
                        datasets: [{
                            data: data.causes.map(cause => cause.percentage),
                            backgroundColor: [
                                '#08141B', '#11212D', '#233745', '#4A5C6A', '#9BAAAB'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Primary Causes of Dropouts',
                                font: {
                                    size: 16,
                                    family: 'Space Grotesk',
                                    weight: '600'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            },
                            legend: { 
                                position: 'right',
                                labels: {
                                    font: {
                                        family: 'Space Grotesk'
                                    }
                                }
                            }
                        }
                    }
                }
            );

            // Strategies Chart
            if (chartInstances[stateLower + 'Strategies']) {
                chartInstances[stateLower + 'Strategies'].destroy();
            }
            chartInstances[stateLower + 'Strategies'] = new Chart(
                document.getElementById(stateLower + 'StrategiesChart').getContext('2d'),
                {
                    type: 'bar',
                    data: {
                        labels: data.strategies,
                        datasets: [{
                            label: 'Impact Potential',
                            data: [30, 25, 20, 15, 10],
                            backgroundColor: [
                                'rgba(8, 20, 27, 0.7)',
                                'rgba(17, 33, 45, 0.7)',
                                'rgba(35, 55, 69, 0.7)',
                                'rgba(74, 92, 106, 0.7)',
                                'rgba(155, 170, 171, 0.7)'
                            ],
                            borderColor: [
                                '#08141B', '#11212D', '#233745', '#4A5C6A', '#9BAAAB'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Strategy Impact Potential',
                                font: {
                                    size: 16,
                                    family: 'Space Grotesk',
                                    weight: '600'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            },
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { 
                                    display: true, 
                                    text: 'Impact Score',
                                    font: {
                                        family: 'Space Grotesk',
                                        weight: '600'
                                    }
                                },
                                ticks: {
                                    font: {
                                        family: 'Space Grotesk'
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        family: 'Space Grotesk'
                                    }
                                }
                            }
                        }
                    }
                }
            );
        }

        // Modal functions
        function openStateModal(stateId) {
            const modal = document.getElementById(stateId + '-modal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            
            // Initialize charts for this state
            const state = stateId.charAt(0).toUpperCase() + stateId.slice(1);
            const stateData = <?= json_encode($states) ?>[state];
            initializeCharts(state, stateData);
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside content
        window.onclick = function(event) {
            document.querySelectorAll('.state-modal').forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        }
        
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