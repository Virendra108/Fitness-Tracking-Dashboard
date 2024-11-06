<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Get user data from session
$first_name = $_SESSION['username']; // Assuming this is set during login
$user_email = $_SESSION['email']; // Assuming this is set during login
$current_date = date('l, F j, Y'); // Current date format
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .stat-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            height: 100%;
        }
        .navbar {
            margin-bottom: 20px;
        }

        .green-card {
            background: rgba(144, 238, 144, 0.1);
        }
        
        .purple-card {
            background: rgba(147, 112, 219, 0.1);
        }
        
        .blue-card {
            background: rgba(173, 216, 230, 0.1);
        }
        
        .light-blue-card {
            background: rgba(135, 206, 235, 0.1);
        }
        
        .progress-circle {
            width: 120px;
            height: 120px;
        }
        
        .map-container {
            height: 300px;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .activity-progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .music-player {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1rem;
        }
        
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Fitness Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.html">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settings.html">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.html">Profile</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Hello, <?php echo htmlspecialchars($first_name); ?>! 👋</h1>
                <small class="text-muted"><?php echo $current_date; ?></small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted"><?php echo htmlspecialchars($user_email); ?></span>
                <img src="/api/placeholder/40/40" alt="Profile" class="profile-img">
                <i class="fas fa-cog"></i>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 mb-4">
            <!-- Active Minutes -->
            <div class="col-md-3">
                <div class="stat-card green-card">
                    <div class="d-flex justify-content-between mb-3">
                        <i class="fas fa-heart"></i>
                        <i class="fas fa-expand"></i>
                    </div>
                    <h6>Active Minutes</h6>
                    <h3 class="mb-3">125 <small>Min</small></h3>
                    <div class="progress activity-progress">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <!-- Calories Burned -->
            <div class="col-md-3">
                <div class="stat-card purple-card">
                    <div class="d-flex justify-content-between mb-3">
                        <i class="fas fa-fire"></i>
                        <i class="fas fa-expand"></i>
                    </div>
                    <h6>Calories Burned</h6>
                    <h3 class="mb-3">882 <small>Kcal</small></h3>
                    <div class="progress activity-progress">
                        <div class="progress-bar bg-purple" style="width: 65%"></div>
                    </div>
                </div>
            </div>

            <!-- Steps Taken -->
            <div class="col-md-3">
                <div class="stat-card blue-card">
                    <div class="d-flex justify-content-between mb-3">
                        <i class="fas fa-shoe-prints"></i>
                        <i class="fas fa-expand"></i>
                    </div>
                    <h6>Steps Taken</h6>
                    <h3 class="mb-3">11,222 <small>Steps</small></h3>
                    <div id="stepsChart"></div>
                </div>
            </div>

            <!-- Water Intake -->
            <div class="col-md-3">
                <div class="stat-card light-blue-card">
                    <div class="d-flex justify-content-between mb-3">
                        <i class="fas fa-tint"></i>
                        <i class="fas fa-expand"></i>
                    </div>
                    <h6>Water Intake</h6>
                    <h3 class="mb-3">3/10 <small>Glasses</small></h3>
                    <div class="progress-circle mx-auto">
                        <div class="progress-circle-inner">52%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Running Activity & Progress -->
        <div class="row g-4 mb-4">
            <!-- Running Map -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bolt text-warning me-2"></i>
                                Running place activity
                            </h5>
                            <button class="btn btn-dark btn-sm">Add workout</button>
                        </div>
                        <div class="map-container mb-3">
                            <img src="/api/placeholder/800/300" alt="Running Map" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Distance</small>
                                <h5 class="mb-0">5.2 km</h5>
                            </div>
                            <div>
                                <small class="text-muted">Time</small>
                                <h5 class="mb-0">26:21 min</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Circle -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Total progress</h5>
                        <div class="progress-circle mx-auto mb-3" style="width: 200px; height: 200px;">
                            <!-- Progress circle would be implemented with JavaScript -->
                        </div>
                        <div class="d-flex justify-content-center gap-4">
                            <div class="text-center">
                                <div class="bg-purple rounded-circle p-2 mb-2"></div>
                                <small>Strength</small>
                            </div>
                            <div class="text-center">
                                <div class="bg-success rounded-circle p-2 mb-2"></div>
                                <small>Endurance</small>
                            </div>
                            <div class="text-center">
                                <div class="bg-info rounded-circle p-2 mb-2"></div>
                                <small>Speed</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity & Music Player -->
        <div class="row g-4">
            <!-- Activity -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Activity</h5>
                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: 55%"></div>
                            <div class="progress-bar bg-info" style="width: 20%"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Daily payment</small>
                                <div>55%</div>
                            </div>
                            <div>
                                <small class="text-muted">Hobby</small>
                                <div>20%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Music Player -->
            <div class="col-md-8">
                <div class="music-player">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-uppercase text-muted">Party</small>
                            <h5 class="mb-0">Great and Marvelous</h5>
                            <small class="text-uppercase text-primary">Today</small>
                        </div>
                        <div class="d-flex gap-3">
                            <i class="fas fa-random"></i>
                            <i class="fas fa-step-backward"></i>
                            <i class="fas fa-play"></i>
                            <i class="fas fa-step-forward"></i>
                            <i class="fas fa-redo"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="/api/placeholder/50/50" alt="Album art" class="me-3 rounded">
                        <div>
                            <h6 class="mb-0">Pink Rabbits</h6>
                            <small class="text-muted">The National</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple steps chart using canvas
        const stepsCanvas = document.createElement('canvas');
        const ctx = stepsCanvas.getContext('2d');
        const stepsData = [8000, 9500, 11000, 10500, 11222, 10800, 11000];
        
        // Set canvas size
        stepsCanvas.width = document.getElementById('stepsChart').offsetWidth;
        stepsCanvas.height = 100;
        
        // Draw steps chart
        ctx.beginPath();
        ctx.moveTo(0, 80);
        stepsData.forEach((steps, index) => {
            const x = (index / (stepsData.length - 1)) * stepsCanvas.width;
            const y = 80 - (steps / 15000) * 60;
            ctx.lineTo(x, y);
        });
        ctx.strokeStyle = '#4dabf7';
        ctx.lineWidth = 2;
        ctx.stroke();
        
        document.getElementById('stepsChart').appendChild(stepsCanvas);
    </script>
</body>
</html>