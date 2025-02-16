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
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>
    
    <h1>Bienvenue dans l'admin</h1>
    
    <section class="dashboard">
        <div class="infos">
            <div class="infos-left">
                <h3>Gestion des Quiz</h3>
                <span>Nombre total : <?= count($quizzes) ?></span>
            </div>
            <div class="infos-right">
                <ul>
                    <li><a href="quizz/create-quiz.php" class="btn-add">Créer un nouveau quiz</a></li>
                </ul>
            </div>
        </div>
        
        <?php foreach ($quizzes as $q): ?>
        <div class="infos">
            <div class="infos-left">
                <h3><?= htmlspecialchars($q['Title']) ?></h3>
                <span><?= htmlspecialchars($q['Description']) ?></span>
            </div>
            <div class="infos-right">
                <ul>
                    <li><a href="quizz/manage_questions.php?quizId=<?= $q['QuizID'] ?>" class="btn-edit">Gérer les questions</a></li>
                    <li><a href="quizz/edit_quiz.php?id=<?= $q['QuizID'] ?>" class="btn-edit">Modifier</a></li>
                    <li><a href="quizz/delete_quiz.php?id=<?= $q['QuizID'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz ?');">Supprimer</a></li>
                </ul>
            </div>
        </div>
        <?php endforeach; ?>
    </section>

    <a href="/quiz-night/admin/auth/logout.php">Se déconnecter</a>
</body>
</html>
