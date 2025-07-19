<?php
session_start();
include 'db_config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        $message = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $password_hash);
            $stmt->fetch();
if (password_verify($password, $password_hash)) {
                // Password is correct, set session
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: adminpanel.php");
                exit();
            } else {
                $message = "Invalid username or password.";
            }
        } else {
            $message = "Invalid username or password.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
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
        input[type="text"], input[type="password"] {
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
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            text-align: center;
        }
        a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required />

        <button type="submit">Login</button>
    </form>
    <p style="text-align:center; margin-top: 15px;">
        Don't have an account? <a href="signup.php">Sign up here</a>.
    </p>
</body>
</html>
