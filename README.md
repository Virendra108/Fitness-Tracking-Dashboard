# Fitness Tracking Dashboard

## Overview

The **Fitness Tracking Dashboard** is a web application designed to help users track their fitness activities, including workouts, steps, calories burned, and water intake. The dashboard provides an intuitive user interface that displays personal fitness data, visualizes running routes on a map, and allows users to manage their fitness goals effectively.

## Features

- User authentication with registration and login functionality.
- Display of user statistics, including active minutes, calories burned, steps taken, and water intake.
- Integration of a map using Leaflet to visualize running routes.
- User-friendly dashboard design with responsive layout.
- Ability to add workouts and track fitness progress.
- Interactive charts for visual representation of fitness data.

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript, Bootstrap, Leaflet
- **Backend:** PHP
- **Database:** MySQL (via `connection.php` for database connection)

## Installation

To run the Fitness Tracking Dashboard locally, follow these steps:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/fitness-tracking-dashboard.git
   cd fitness-tracking-dashboard
   
2. **Set up the database:**

- Create a new MySQL database and update the connection.php file with your database credentials.
- Import the SQL schema (if available) to set up necessary tables.

3. **Run the application:**

- Ensure you have a local server environment set up (e.g., XAMPP, MAMP).
- Place the project files in the server's root directory (e.g., htdocs for XAMPP).
- Access the application through your web browser at http://localhost/fitness-tracking-dashboard.
