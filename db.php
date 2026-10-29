
<?php

$host = '192.168.10.30';
$db   = 'app_db';
$user = 'webuser';
$pass = 'LabPassword123!';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die("Database Connection Error: " . $e->getMessage());
}

?>