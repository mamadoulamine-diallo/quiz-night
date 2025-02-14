<?php 

require_once __DIR__ . '/../../classes/Quiz.php';
require_once __DIR__ . '/../auth/auth.php';

if (!isset($_SESSION['user_id'])) {
    die("Erreur : utilisateur non connecté.");
}

$quiz = new Quiz();

if (!isset($_GET['id'])) {
    die("Erreur : ID du quiz manquant.");
}

$quizId = $_GET['id'];
$quizData = $quiz->getQuizById($quizId);

if (!$quizData) {
    die("Erreur : Quiz introuvable.");
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        if ($quiz->updateQuiz($quizId, $title, $description)) {
            $message = "Quiz mis à jour avec succès !";
            $quizData = $quiz->getQuizById($quizId); 
        } else {
            $message = "Erreur lors de la mise à jour du quiz.";
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
    <title>Modifier le Quiz</title>
</head>
<body>
    <h2>Modifier le Quiz</h2>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="title">Titre du Quiz :</label>
        <input type="text" name="title" value="<?= htmlspecialchars($quizData['Title']) ?>" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required><?= htmlspecialchars($quizData['Description']) ?></textarea><br>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <a href="../index.php">Retour</a>
</body>
</html>




