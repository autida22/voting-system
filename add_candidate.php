<?php
include 'db_config.php';

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $section = $conn->real_escape_string($_POST['section']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $position = $conn->real_escape_string($_POST['position']);

    // Handle image upload
    $image_path = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $conn->real_escape_string($target_file);
        } else {
            $error_message = "Failed to upload image.";
        }
    }

    if (empty($error_message)) {
        $sql = "INSERT INTO candidates (name, section, grade, position, image_path) VALUES ('$name', '$section', '$grade', '$position', " . ($image_path ? "'$image_path'" : "NULL") . ")";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Candidate added successfully.";
            // Optionally clear POST data to prevent resubmission on refresh
            $_POST = array();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Candidates</title>
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
            max-width: 600px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }
        input, select {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #357ABD;
        }
        a.back-link {
            display: inline-block;
            margin-top: 20px;
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        <h1>Add Candidate</h1>
        <?php if ($success_message): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form enctype="multipart/form-data" method="POST" action="">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter candidate name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />

            <label for="section">Section</label>
            <input type="text" id="section" name="section" placeholder="Enter section" required value="<?php echo isset($_POST['section']) ? htmlspecialchars($_POST['section']) : ''; ?>" />

            <label for="grade">Grade</label>
            <input type="text" id="grade" name="grade" placeholder="Enter grade" required value="<?php echo isset($_POST['grade']) ? htmlspecialchars($_POST['grade']) : ''; ?>" />

            <label for="position">Position</label>
            <select id="position" name="position" required>
                <option value="" disabled <?php echo !isset($_POST['position']) ? 'selected' : ''; ?>>Select position</option>
                <option value="president" <?php echo (isset($_POST['position']) && $_POST['position'] === 'president') ? 'selected' : ''; ?>>President</option>
                <option value="vice-president" <?php echo (isset($_POST['position']) && $_POST['position'] === 'vice-president') ? 'selected' : ''; ?>>Vice President</option>
                <option value="secretary" <?php echo (isset($_POST['position']) && $_POST['position'] === 'secretary') ? 'selected' : ''; ?>>Secretary</option>
                <option value="treasurer" <?php echo (isset($_POST['position']) && $_POST['position'] === 'treasurer') ? 'selected' : ''; ?>>Treasurer</option>
            </select>

            <label for="image">Upload Image</label>
            <input type="file" id="image" name="image" accept="image/*" />

            <button type="submit">Add Candidate</button>
        </form>
        <a href="adminpanel.php" class="back-link">Back to Dashboard</a>
    </main>
