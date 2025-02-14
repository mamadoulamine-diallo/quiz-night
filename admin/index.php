<?php
require_once __DIR__ . '/auth/auth.php';

require_once __DIR__ . '/../classes/Quiz.php';




$quiz = new Quiz();
$quizzes = $quiz->getAllQuizzes();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Quiz</title>
</head>

<body>
    <h1>Bienvenue dans l'admin</h1>

    <h2>Liste des Quiz</h2>

    <a href="quizz/create-quiz.php">Créer un nouveau quiz</a>




    <ul>
    <?php foreach ($quizzes as $q): ?>
        <li>
            <strong><?= htmlspecialchars($q['Title']) ?></strong> - <?= htmlspecialchars($q['Description']) ?>
            <a href="quizz/manage_questions.php?quizId=<?= $q['QuizID'] ?>">Gérer les questions</a>
            <a href="quizz/edit_quiz.php?id=<?= $q['QuizID'] ?>">Modifier</a>
            <a href="quizz/delete_quiz.php?id=<?= $q['QuizID'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz ?');">Supprimer</a>
        </li>
    <?php endforeach; ?>
</ul>

    <a href="/quiz-night/admin/auth/logout.php">Se déconnecter</a>
</body>

</html>