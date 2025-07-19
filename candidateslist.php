<?php
include 'db_config.php';

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM candidates WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: candidateslist.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT * FROM candidates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Candidates List</title>
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
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4a90e2;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        img.candidate-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        button.edit-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 6px 12px;
            margin-right: 8px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        button.edit-btn:hover {
            background-color: #357ABD;
        }
        button.delete-btn {
            background-color: #e94e4e;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        button.delete-btn:hover {
            background-color: #c03939;
        }
    </style>
</head>
<body>
    <header>Admin Panel</header>
    <nav class="sidebar">
        <a href="adminpanel.php">Dashboard</a>
        <a href="add_candidate.php">Add Candidates</a>
        <a href="candidateslist.php">Candidates List</a>
         <a href="votes_result.php">Votes Result</a>
    </nav>
    <main class="content">
        <h1>Candidates List</h1>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Grade</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>";
                        if (!empty($row['image_path'])) {
                            echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Candidate Image' class='candidate-img' />";
                        } else {
                            echo "No Image";
                        }
                        echo "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['section']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td>";
echo "<a href='edit_candidate.php?id=" . intval($row['id']) . "'><button class='edit-btn'>Edit</button></a>";
                        echo "<a href='candidateslist.php?delete_id=" . intval($row['id']) . "' onclick=\"return confirm('Are you sure you want to delete " . htmlspecialchars($row['name']) . "?');\"><button class='delete-btn'>Delete</button></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No candidates found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="adminpanel.php" class="back-link">Back to Dashboard</a>
    </main>
</body>
</html>
