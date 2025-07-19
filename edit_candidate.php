<?php
include 'db_config.php';

if (!isset($_GET['id'])) {
    header("Location: candidateslist.php");
    exit();
}

$id = intval($_GET['id']);
$error = '';
$success = '';

// Fetch candidate data
$sql = "SELECT * FROM candidates WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    header("Location: candidateslist.php");
    exit();
}

$candidate = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $section = $conn->real_escape_string($_POST['section']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $position = $conn->real_escape_string($_POST['position']);
    // For simplicity, image update is not handled here

    $update_sql = "UPDATE candidates SET 
        name = '$name',
        section = '$section',
        grade = '$grade',
        position = '$position'
        WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: candidateslist.php");
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Candidate</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            color: #333;
            justify-content: center;
            align-items: center;
        }
        .edit-form {
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
        }
        .edit-form h1 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #4a90e2;
        }
        .edit-form label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }
        .edit-form input[type="text"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .edit-form button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            font-size: 1rem;
        }
        .edit-form button:hover {
            background-color: #357ABD;
        }
        .error {
            color: #e94e4e;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form class="edit-form" method="POST" action="">
        <h1>Edit Candidate</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($candidate['name']); ?>" required />

        <label for="section">Section</label>
        <input type="text" id="section" name="section" value="<?php echo htmlspecialchars($candidate['section']); ?>" required />

        <label for="grade">Grade</label>
        <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($candidate['grade']); ?>" required />

        <label for="position">Position</label>
        <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($candidate['position']); ?>" required />

        <button type="submit">Update Candidate</button>
        <a href="candidateslist.php" class="back-link">Back to Candidates List</a>
    </form>
</body>
</html>
