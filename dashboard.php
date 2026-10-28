<?php

// start or resume existing session
session_start();

// check if user_id doesnt exist, if not send back to login.php and terminate script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();

}
?>
<!DOCTYPE HTML>

<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <main class="container" style="max-width: 600px; padding-top: 10vh;">
    <article style="text-align: center;">
        <h2>Internal Lab Dashboard</h2>
        <p>
        Welcome, <strong>
        <?php echo htmlspecialchars($_SESSION['email']); // print the logged in users email, htmlspecialchars makes sure special html characters are changes to harmless html entities for security?>
</strong> </p> 
<p>Succesfully logged in to the Lab Portal.</p>

<a href="profile.php"
role="button" class="secondary">My Profile</a>
<br style="margin-bottom: 2rem;">

<?php // makes only users with rank 2 or higher even see the Create Account button to not allow them to register.php and prevent confusion
 if ($_SESSION['rank'] >= 2): ?>
<a href="register.php"
role="button" class="secondary">Create Account</a>
<br style="margin-bottom: 2rem;">
<?php endif; ?>
<a href="logout.php"
role="button" class="secondary">Log Out</a>
        </article>
    </main>
</body>

</html>

