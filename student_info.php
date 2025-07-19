<?php
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName']);
    $grade = trim($_POST['grade']);
    $section = trim($_POST['section']);

    if ($fullName === '' || $grade === '' || $section === '') {
        $message = "Please fill in all fields.";
    } elseif (isset($_SESSION['user_name']) && $_SESSION['user_name'] === $fullName) {
        $message = "The name was taken.";
    } else {
        // Store in session
        $_SESSION['user_name'] = $fullName;
        $_SESSION['user_grade'] = $grade;
        $_SESSION['user_section'] = $section;
        // Redirect to uservoting.php
        header("Location: uservoting.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Information</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            color: #4a90e2;
            text-align: center;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 30px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }
        input[type="text"] {
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
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #357ABD;
        }
        .message {
            max-width: 400px;
            margin: 20px auto;
            padding: 15px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="topnav">
        <a href="login.php">Admin Panel</a>
        <a href="student_info.php" class="active">Student Info</a>
    </nav>
    <h1>Student Information</h1>
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="student_info.php">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required />

        <label for="grade">Grade</label>
        <input type="text" id="grade" name="grade" placeholder="Enter your grade" required />

        <label for="section">Section</label>
        <input type="text" id="section" name="section" placeholder="Enter your section" required />

        <button type="submit">I need to Vote</button>
    </form>
</body>
</html>

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .topnav {
        background-color: #4a90e2;
        overflow: hidden;
        display: flex;
        justify-content: center;
        gap: 20px;
        padding: 14px 0;
    }
    .topnav a {
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: background-color 0.3s ease;
        border-radius: 4px;
    }
    .topnav a:hover {
        background-color: #357ABD;
    }
    .topnav a.active {
        background-color: #2c5aa0;
    }
</style>
