<?php

// start or resume existing session
session_start();

require_once 'db.php';

// check if user_id doesnt exist, if not send back to login.php and terminate script
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();

}
// get user profile data linked to the logged in user id
$stmt = $conn->prepare("SELECT full_name, position, age, gender FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();

// the rank in words to make it more clear for the user
$rank_titles = [
    0 => '0, Standard User',
    1 => '1, IT Support',
    2 => '2, Manager',
    3 => '3, Administrator'
];
$user_rank = $rank_titles[$_SESSION['rank']] ?? 'Rank' . $_SESSION['rank'];
?>
<!DOCTYPE HTML>

<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <main class="container" style="max-width: 600px; padding-top: 10vh;">
    <article style="text-align: center;">
        <h2>Your Profile</h2>
        <p>
        <strong>Full Name: </strong>
        <?php echo htmlspecialchars($profile['full_name'] ?? 'Not specified'); // print the information?> </p>
        <p><strong>Position: </strong>
        <?php echo htmlspecialchars($profile['position'] ?? 'Not specified'); ?> </p>
        <p><strong>Rank: </strong>
        <?php echo htmlspecialchars($user_rank);?> </p>
        <p><strong>Age: </strong>
        <?php echo htmlspecialchars($profile['age'] ?? 'Not specified'); ?> </p>
        <p><strong>Gender: </strong>
        <?php echo htmlspecialchars($profile['gender'] ?? 'Not specified'); ?> </p>
 </p> 

<div style="text-align: center;">
    <a href="dashboard.php" role="button" style="margin-bottom: 1rem;">Back to Dashboard</a>
    <br>    

<a href="logout.php"
role="button" class="secondary">Log Out</a>

<p style="font-size: 0.85rem; margin-top: 1rem;"> Is any information incorrect?<br>
    <a href="contact.php">Contact IT</a>
</p>
</div>
        </article>
    </main>
</body>

</html>
