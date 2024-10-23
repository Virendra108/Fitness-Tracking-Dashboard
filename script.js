document.addEventListener("DOMContentLoaded", function() {
    // Dummy data for charts and elements

    // Progress chart (weight tracking)
    const ctx = document.getElementById('weightChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Weight (kg)',
                data: [70, 68.5, 67.5, 66.8],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Keep aspect ratio fixed
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    // Sleep tracker chart
    const sleepCtx = document.getElementById('sleepChart').getContext('2d');
    new Chart(sleepCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Hours of Sleep',
                data: [7, 8, 6, 7, 9, 8, 7],
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Fix chart size to avoid growth
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Dummy data for other sections
    document.getElementById("steps").textContent = "8500";
    document.getElementById("caloriesBurned").textContent = "500";
    document.getElementById("caloriesConsumed").textContent = "2200";

    // Goals list
    const goals = ['Run 5km in under 25 minutes', 'Lose 5kg by next month', 'Increase bench press weight by 10kg'];
    const goalsList = document.getElementById('goals-list');
    goals.forEach(goal => {
        const li = document.createElement('li');
        li.textContent = goal;
        goalsList.appendChild(li);
    });

    // Exercise log
    const exercises = ['Push-ups: 3 sets of 15', 'Squats: 4 sets of 12', 'Running: 30 minutes'];
    const exerciseList = document.getElementById('exercise-list');
    exercises.forEach(exercise => {
        const li = document.createElement('li');
        li.textContent = exercise;
        exerciseList.appendChild(li);
    });

    // Leaderboard
    const leaderboard = ['Virendra - 15000 steps', 'Ishwar - 13000 steps', 'Akhilesh - 12000 steps','Parth - 11000 steps'];
    const leaderboardList = document.getElementById('leaderboard-list');
    leaderboard.forEach(user => {
        const li = document.createElement('li');
        li.textContent = user;
        leaderboardList.appendChild(li);
    });

    // Achievements
    const achievements = ['Completed 30-day fitness challenge', 'Lost 5kg in 2 months', 'Ran a 10k marathon'];
    const achievementsList = document.getElementById('achievements-list');
    achievements.forEach(achievement => {
        const li = document.createElement('li');
        li.textContent = achievement;
        achievementsList.appendChild(li);
    });
});

