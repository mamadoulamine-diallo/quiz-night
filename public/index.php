<?php
require_once __DIR__ . '/../classes/Quiz.php';

$quizObj = new Quiz();
$quizzes = $quizObj->getAllQuizzes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Quiz</title>
</head>
<body>
    <h2>Quiz Disponibles</h2>
    <ul>
        <?php foreach ($quizzes as $quiz): ?>
            <li>
                <a href="quiz.php?quizId=<?= $quiz['QuizID'] ?>">
                    <?= htmlspecialchars($quiz['Title']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
