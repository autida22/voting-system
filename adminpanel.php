<?php
include 'db_config.php';

$sql = "SELECT name, votes, image_path, position FROM candidates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            color: #333;
        }
        nav.sidebar {
            width: 220px;
            background-color: #4a90e2;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
        }
        nav.sidebar a {
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }
        nav.sidebar a:hover {
            background-color: #357ABD;
        }
        header {
            background-color: #4a90e2;
            color: white;
            padding: 20px 40px;
            font-size: 1.8rem;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex-shrink: 0;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        main.content {
            flex-grow: 1;
            padding: 80px 40px 40px 260px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin: 20px;
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
        .dashboard {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
            flex: 1 1 200px;
            min-width: 200px;
            text-align: center;
        }
        .card h2 {
            margin: 0 0 10px 0;
            font-size: 2.5rem;
            color: #4a90e2;
        }
        .card p {
            margin: 0;
            font-size: 1.1rem;
            color: #666;
        }
        .card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>Admin Panel</header>
    <nav class="sidebar">
        <a href="adminpanel.php">Dashboard</a>
        <a href="add_candidate.php">Add Candidates</a>
        <a href="candidateslist.php">Candidates List</a>
          <a href="student_info.php" class="active">Votes</a>
        <a href="votes_result.php">Votes Result</a>
        <a href="student_info.php">Logout</a>
    </nav>
<?php
if (isset($_GET['delete_votes']) && $_GET['delete_votes'] == '1') {
    // Reset all votes to zero
    $reset_sql = "UPDATE candidates SET votes = 0";
    if ($conn->query($reset_sql) === TRUE) {
        header("Location: adminpanel.php");
        exit();
    } else {
        echo "Error resetting votes: " . $conn->error;
    }
}
?>
    <main class="content">
        <h1>Welcome Admin!!!</h1>
        <p>Use the sidebar to navigate through the admin options.</p>
        <form method="GET" onsubmit="return confirm('Are you sure you want to delete all votes?');" style="margin-bottom: 20px;">
            <input type="hidden" name="delete_votes" value="1" />
            <button type="submit" style="background-color: #e94e4e; color: white; border: none; padding: 10px 20px; font-size: 1rem; cursor: pointer; border-radius: 5px;">Delete Votes</button>
        </form>
        <div class="dashboard">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    if (!empty($row['image_path'])) {
                        echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Candidate Image' style='width: 20%; height: auto; max-height: 150px; object-fit: cover; border-radius: 8px 8px 0 0; margin-bottom: 10px;' />";
                    }
                    echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                    echo "<p>Votes: " . intval($row['votes']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No candidates found.</p>";
            }
            ?>
        </div>
    </main>
    <footer>
        &copy; 2025 Admin Panel
    </footer>
</body>
</html>
