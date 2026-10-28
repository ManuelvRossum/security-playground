<!DOCTYPE HTML>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab Login</title>
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container" style="max-width: 600px; margin-top: 10vh;">
        <h2 style="text-align: center; letter-spacing: 2px; margin-bottom: 4rem;">Lab Portal Login</h2>
        <article>
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