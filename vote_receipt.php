<?php
session_start();

if (!isset($_SESSION['voted_candidates']) || empty($_SESSION['voted_candidates'])) {
    header("Location: uservoting.php");
    exit();
}

$voted_candidates = $_SESSION['voted_candidates'];

// Clear voted candidates from session after displaying receipt
unset($_SESSION['voted_candidates']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vote Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .receipt {
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #4a90e2;
            margin-bottom: 20px;
        }
        ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 20px;
        }
        li {
            font-size: 1.1rem;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
        }
        a.back-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        a.back-link:hover {
            background-color: #357ABD;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h1>Vote Receipt</h1>
        <p>You have successfully voted for the following candidates:</p>
        <ul>
            <?php foreach ($voted_candidates as $candidate): ?>
                <li><?php echo htmlspecialchars($candidate); ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="student_info.php" class="back-link">Done!!!</a>
        <script>
            // Clear session storage or cookies if needed to reset user info form
            // Since PHP session is server-side, user info form will show if session is cleared on voting page
        </script>
    </div>
</body>
</html>
