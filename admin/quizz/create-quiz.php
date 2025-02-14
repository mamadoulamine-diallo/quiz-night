<?php 



require_once __DIR__ . '/../../classes/Admin.php';
require_once __DIR__ . '/../../classes/Quiz.php';

require_once __DIR__ . '/../auth/auth.php';

if (!isset($_SESSION['user_id'])) {
    die("Erreur : utilisateur non connecté.");
}

$userId = $_SESSION['user_id']; 
$quiz = new Quiz();





$quiz = new Quiz();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        if ($quiz->addQuiz($userId, $title, $description)) 
        {
            $message = "Quiz créé avec succès !";
        } else {
            $message = "Erreur lors de la création du quiz.";
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Quiz</title>
</head>
<body>
    <h2>Créer un nouveau quiz</h2>
    
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="title">Titre du Quiz :</label>
        <input type="text" name="title" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <button type="submit">Créer</button>
    </form>

    <a href="index.php">Retour à la gestion des quiz</a>
</body>
</html>