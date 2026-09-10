<?php
require 'includes/auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMonitor - Health Data</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="data-section">
        <div class="container">
            <h1>Health Data</h1>

            <div class="date-filter">
                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date" name="start-date">

                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end-date">

                <button onclick="loadData()">View Data</button>
            </div>

            <div class="data-table">
                <h2>Health Data History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>BPM</th>
                            <th>SpO2</th>
                        </tr>
                    </thead>
                    <tbody id="data-table-body">
                        <!-- rows inserted by healthdata.js -->
                    </tbody>
                </table>
            </div>

            <div class="graph-section">
                <h2>Health Data Trends</h2>
                <canvas id="healthChart"></canvas>
            </div>
        </div>
    </section>

    <script src="assets/js/healthdata.js"></script>
</body>
</html>
