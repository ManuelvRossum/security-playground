<?php

session_start();
// bring the user back to login page if they arent logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// bring user back to dashboard if they arent high enough rank
if (!isset($_SESSION['rank']) || $_SESSION['rank'] < 2) {
    header("Location: dashboard.php");
    exit();
}
require_once 'db.php';

// variables for alerts
$error = '';
$success = '';

// handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $rank = (int)($_POST['rank'] ?? 0);
    $full_name = $_POST['full_name'] ?? '';
    $position = $_POST['position'] ?? '';
    $age = (int)($_POST['age'] ?? '');
    $gender = $_POST['gender'] ?? '';
    if (empty($email) || empty($password) || empty($full_name)) {
        $error = "Email, password, rank and full name are required";
    } else {
        // check for other user with same email
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        // error for when email matches with an account with same email
        if ($result->fetch_assoc()) {
            $error = "An account with that email already exists.";
        } else { //insert user data
            $insert_stmt = $conn->prepare("INSERT INTO users (email, password, rank) VALUES (?, ?, ?)");
                $insert_stmt->bind_param("ssi", $email, $password, $rank);
                $insert_stmt->execute();
                $new_user_id = $conn->insert_id;
                $profile_stmt = $conn->prepare("INSERT INTO user_profiles (user_id, full_name, position, age, gender) VALUES (?, ?, ?, ?, ?)");    
                $profile_stmt->bind_param("issis", $new_user_id, $full_name, $position, $age, $gender);
                if ($profile_stmt->execute()) {
                        $success = "Account created successfully for " . 
                        htmlspecialchars($email) . " (rank $rank).";
                    } else {
                        $error = "Failed to create account. Please try again, or contact IT.";
                    }
        }
    }


    
    }



?>

<!DOCTYPE HTML>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab Account Creation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="container" style="max-width: 600px; padding-top: 10vh;">
        <h2 style="text-align: center; letter-spacing: 2px; margin-bottom: 4rem;">Lab Portal Account Creation</h2>
        <article>
            <?php 
                // if error variable is not empty
                if (!empty($error)): ?>
                <div style="background-color: #ef4444; color: white; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.25rem; text-align: center; font-size: 0.9rem;">
                 <?php //print the error
                 echo htmlspecialchars($error); ?>
                </div>
                <?php endif; 
                if (!empty($success)): ?>
                <div style="background-color: #10b981; color: white; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.25rem; text-align: center; font-size: 0.9rem;"> 
                <?php echo $success; ?>
                </div>
                <?php endif; ?>
            <p style="text-align: center; margin-bottom: 1.5rem;">
                Enter new account email and password:
            </p>
            <form action="register.php" method="POST">
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="E-mail"
                    required
                >
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required
                >
                <input
                    type="number"
                    min="0"
                    max="3"
                    id="rank"
                    name="rank"
                    placeholder="Rank"
                    required
                >
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    placeholder="Full Name"
                    required
                >
                <input
                    type="text"
                    id="position"
                    name="position"
                    placeholder="Position"
                >
                <input
                    type="number"
                    min="16"
                    max="100"
                    id="age"
                    name="age"
                    placeholder="Age"
                >
                <input
                    type="text"
                    id="gender"
                    name="gender"
                    placeholder="Gender"
                >
                <button type="submit">CREATE ACCOUNT</button>
            </form>
            <div style="text-align: center; margin-top: 1rem;">
                <a href="dashboard.php" role="button" style="font-size: 0.85rem;">Back to Dashboard</a>
            </div>
            <p style="text-align: center; margin-top: 1rem; font-size: 0.85rem;">
                Failed to create an account?<br>
                    <a href="contact.php">Contact IT</a>
            </p>
        </article>
    </main>
</body>
</html> 
