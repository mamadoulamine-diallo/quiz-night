<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>

    <?php
    session_start();
    if (!empty($_SESSION['form_errors'])) {
        echo '<ul style="color: red;">';
        foreach ($_SESSION['form_errors'] as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
        unset($_SESSION['form_errors']); 
    }
    ?>

    <form action="register_process.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required value="<?= $_SESSION['old_data']['username'] ?? '' ?>"><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required value="<?= $_SESSION['old_data']['email'] ?? '' ?>"><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
