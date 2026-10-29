
<?php
// start session
session_start();
// import database connection
require_once 'db.php';
// error variable
$error = '';
// check if the form was submitted via post and retrieve the submitted data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // intentionally vunerable query, more info in realisation document

    $sql = "SELECT id, email, password, rank FROM users WHERE email = '$email' AND password = '$password'";

    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    // check if a user was found
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['rank'] = $user['rank'];

        // go to dashboard
        header("Location: dashboard.php");
        exit();
    } else { //set error message for failed
        $error = "Invalid email or password.";
    }
}

?>
<!DOCTYPE HTML>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="container" style="max-width: 600px; padding-top: 10vh;">
        <h2 style="text-align: center; letter-spacing: 2px; margin-bottom: 4rem;">Lab Portal Login</h2>
        <article>
            <?php 
                // if error variable is not empty
                if (!empty($error)): ?>
                <div style="background-color: #ef4444; color: white; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.25rem; text-align: center; font-size: 0.9rem;">
                 <?php //print the error
                 echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>   
            <p style="text-align: center; margin-bottom: 1.5rem;">
                Enter your Lab account username and password:
            </p>
            <form action="login.php" method="POST">
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
                <button type="submit">LOGIN</button>
            </form>
            <p style="text-align: center; margin-top: 1rem; font-size: 0.85rem;">
                Can't login, don't have an account or experiencing other issues?<br>
                    <a href="contact.php">Contact IT</a>
            </p>
        </article>
    </main>
</body>
</html> 