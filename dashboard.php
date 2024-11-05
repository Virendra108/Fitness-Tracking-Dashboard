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
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            padding: 20px;
            background-color: white;
            color: black;
            text-align: center;
        }
        .navbar {
            margin-bottom: 20px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f0f0f0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            position: relative;
        }

        .stat-card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
        }

        .stat-card .unit {
            font-size: 14px;
            color: #666;
        }

        .bottom-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .map-section {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            grid-column: span 2;
        }

        .map-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .map-container {
            width: 100%;
            height: 300px;
            background: #f0f0f0;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .activity-section {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
        }

        .progress-circle {
            width: 150px;
            height: 150px;
            margin: 20px auto;
            position: relative;
        }

        .music-player {
            background: #fff;
            border-radius: 15px;
            padding: 15px;
            margin-top: 20px;
        }

        .music-controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        .control-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: #f0f0f0;
            cursor: pointer;
        }
        .add-workout-btn {
            background-color: black; /* Black background */
            color: white; /* White text */
            border: none; /* Remove border */
            border-radius: 5px; /* Slightly rounded corners */
            padding: 10px 20px; /* Padding for a rectangular shape */
            cursor: pointer; /* Pointer cursor on hover */
        }
        /* Charts */
        .bar-chart {
            height: 60px;
            display: flex;
            align-items: flex-end;
            gap: 4px;
        }

        .bar {
            flex: 1;
            background: #007bff;
            opacity: 0.7;
        }

        .water-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 8px solid #e9ecef;
            position: relative;
            margin: 10px auto;
        }

        .water-fill {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: #007bff;
            border-radius: 0 0 50% 50%;
        }
    </style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

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
<div class="dashboard">
    

        <div class="header">
            <div>
		<h1>Hey, <?php echo htmlspecialchars($first_name); ?>!</h1>
                <p><?php echo $current_date; ?></p>
    		
            </div>
            <div class="user-info">
                <span><?php echo htmlspecialchars($user_email); ?></span>
                <div class="user-avatar"></div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Active Minutes</h3>
                <div class="bar-chart">
                    <div class="bar" style="height: 60%"></div>
                    <div class="bar" style="height: 80%"></div>
                    <div class="bar" style="height: 40%"></div>
                    <div class="bar" style="height: 90%"></div>
                    <div class="bar" style="height: 70%"></div>
                    <div class="bar" style="height: 50%"></div>
                    <div class="bar" style="height: 85%"></div>
                </div>
                <div class="value">125 <span class="unit">Min</span></div>
            </div>

            <div class="stat-card">
                <h3>Calories Burned</h3>
                <div class="bar-chart">
                    <div class="bar" style="height: 70%"></div>
                    <div class="bar" style="height: 65%"></div>
                    <div class="bar" style="height: 80%"></div>
                    <div class="bar" style="height: 75%"></div>
                    <div class="bar" style="height: 60%"></div>
                    <div class="bar" style="height: 55%"></div>
                    <div class="bar" style="height: 50%"></div>
                </div>
                <div class="value">882 <span class="unit">Kcal</span></div>
            </div>

            <div class="stat-card">
                <h3>Steps Taken</h3>
                <canvas id="stepsChart" width="100" height="60"></canvas>
                <div class="value">11,222 <span class="unit">Steps</span></div>
            </div>

            <div class="stat-card">
                <h3>Water Intake</h3>
                <div class="water-circle">
                    <div class="water-fill" style="height: 52%"></div>
                </div>
                <div class="value">3/10 <span class="unit">Glasses</span></div>
            </div>
        </div>

        <div class="bottom-section">
            <div class="map-section">
                <div class="map-header">
                    <h3>⚡ Running place activity</h3>
                    <button class="add-workout-btn" data-toggle="modal" data-target="#addWorkoutModal">Add Workout</button>
                </div>
                <!-- Map container for Leaflet map -->
                <div id="map" class="map-container"></div>
                <div style="margin-top: 15px">
                    <p>Interval Running</p>
                    <p>5.2 km • 26:21 min</p>
                </div>
            </div>

            <div class="activity-section">
                <h3>Activity</h3>
                <div class="progress-circle">
                    <canvas id="activityChart" width="150" height="150"></canvas>
                </div>
                <div style="text-align: center">
                    <p>Daily payment: 55%</p>
                    <p>Hobby: 20%</p>
                </div>

                <div class="music-player">
                    <h4>Great and Marvelous</h4>
                    <p>Pink Rabbits - The National</p>
                    <div class="music-controls">
                        <button class="control-btn">⟲</button>
                        <button class="control-btn">⏮</button>
                        <button class="control-btn">▶</button>
                        <button class="control-btn">⏭</button>
                        <button class="control-btn">↻</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Steps Chart
        const stepsCtx = document.getElementById('stepsChart').getContext('2d');
        const steps = [8000, 9000, 11000, 10000, 11222, 9500, 8800];
        const maxStep = Math.max(...steps);
        
        stepsCtx.beginPath();
        stepsCtx.moveTo(0, 50);
        steps.forEach((step, index) => {
            const x = (index / (steps.length - 1)) * stepsCtx.canvas.width;
            const y = 50 - (step / maxStep) * 40;
            if (index === 0) {
                stepsCtx.moveTo(x, y);
            } else {
                stepsCtx.lineTo(x, y);
            }
        });
        stepsCtx.strokeStyle = '#007bff';
        stepsCtx.lineWidth = 2;
        stepsCtx.stroke();

        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const centerX = 75;
        const centerY = 75;
        const radius = 60;

        // Draw background circle
        activityCtx.beginPath();
        activityCtx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
        activityCtx.strokeStyle = '#f0f0f0';
        activityCtx.lineWidth = 10;
        activityCtx.stroke();

        // Draw progress arc (75%)
        activityCtx.beginPath();
        activityCtx.arc(centerX, centerY, radius, -Math.PI/2, (2 * Math.PI * 0.75) - Math.PI/2);
        activityCtx.strokeStyle = '#28a745';
        activityCtx.stroke();
    </script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
    // Initialize the map
    var map = L.map('map').setView([51.505, -0.09], 13); // Set initial coordinates and zoom level

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Define a realistic route following streets
    var route = [
        [51.505, -0.09],    // Starting point
        [51.506, -0.091],   // Slight turn
        [51.507, -0.092],   // Straight path
        [51.508, -0.093],   // Turn again
        [51.509, -0.094],   // Continuing on the street
        [51.51, -0.095],    // Further down the street
        [51.511, -0.096]    // Ending point
    ];

    // Draw polyline on the map
    L.polyline(route, { color: 'blue', weight: 4 }).addTo(map);

    // Zoom the map to fit the polyline
    map.fitBounds(route);
</script>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
