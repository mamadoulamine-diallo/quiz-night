<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>

    <?php
    session_start();
    if (!empty($_SESSION['login_errors'])) {
        echo '<ul style="color: red;">';
        foreach ($_SESSION['login_errors'] as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
        unset($_SESSION['login_errors']);
    }
    ?>

    <form action="login_process.php" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required value="<?= $_SESSION['old_login']['email'] ?? '' ?>"><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
