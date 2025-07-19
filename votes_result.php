<?php
include 'db_config.php';

$sql = "SELECT name, votes, position FROM candidates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Votes Result</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #4a90e2;
            color: white;
            padding: 20px 40px;
            font-size: 1.8rem;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        main.content {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 20px 40px 40px 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 8px;
        }
        footer {
            background-color: #4a90e2;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 0.9rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            left: 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>Votes Result</header>
    <main class="content">
        <canvas id="votesChart" style="max-width: 600px; margin-top: 20px;"></canvas>
        <button id="clearDataBtn" style="margin-top: 20px; padding: 10px 20px; font-size: 1rem; cursor: pointer;">Clear Data</button>
         <a href="adminpanel.php" class="back-link">Back to Dashboard</a>
    </main>
    <footer>
        &copy; 2025 Votes Result
    </footer>
    <script>
        const ctx = document.getElementById('votesChart').getContext('2d');
        const votesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    $labels = [];
                    while($row = $result->fetch_assoc()) {
                        $labels[] = "'" . addslashes($row['name']) . " (" . addslashes($row['position']) . ")'";
                    }
                    echo implode(',', $labels);
                    ?>
                ],
                datasets: [{
                    label: 'Votes',
                    data: [
                        <?php
                        $result->data_seek(0);
                        $votes = [];
                        while($row = $result->fetch_assoc()) {
                            $votes[] = intval($row['votes']);
                        }
                        echo implode(',', $votes);
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)',
                        'rgba(83, 102, 255, 0.7)',
                        'rgba(255, 99, 255, 0.7)',
                        'rgba(99, 255, 132, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)',
                        'rgba(83, 102, 255, 1)',
                        'rgba(255, 99, 255, 1)',
                        'rgba(99, 255, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Votes per Candidate'
                    }
                }
            }
        });

        // Clear data button functionality
        document.getElementById('clearDataBtn').addEventListener('click', () => {
            votesChart.data.labels = [];
            votesChart.data.datasets.forEach(dataset => {
                dataset.data = [];
            });
            votesChart.update();
        });
    </script>
</body>
</html>
