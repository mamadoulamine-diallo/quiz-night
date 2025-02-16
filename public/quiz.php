<?php
session_start();

require_once __DIR__ . '/../classes/Quiz.php';
require_once __DIR__ . '/../classes/Question.php';
require_once __DIR__ . '/../classes/Response.php';

$quizId = $_GET['quizId'] ?? null;
if (!$quizId) {
    header("Location: index.php");
    exit();
}

$playerId = $_SESSION['player_id'] ?? null;
$playerName = $_SESSION['player_name'] ?? '';
$playerEmail = $_SESSION['player_email'] ?? '';

$quizObj = new Quiz();
$questionObj = new Question();
$responseObj = new Response();

$quiz = $quizObj->getQuizById($quizId);
$questions = $questionObj->getQuestionsByQuizId($quizId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($quiz['Title']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/quiz.css">
</head>
<body>
    <?php include "../includes/header.php"; ?>

    <h2><?= htmlspecialchars($quiz['Title']) ?></h2>
    <form action="submit_quiz.php" method="POST">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">

        <?php foreach ($questions as $question): ?>
            <div class="question-box">
                <h3><?= htmlspecialchars($question['QuestionText']) ?></h3>
            </div>
            <div class="answers-container">
                <?php 
                $responses = $responseObj->getResponsesByQuestion($question['QuestionID']);
                foreach ($responses as $response): ?>
                    <label class="answer-button">
                        <input type="radio" class="answer-radio" name="question_<?= $question['QuestionID'] ?>" value="<?= $response['ResponseID'] ?>" required>
                        <?= htmlspecialchars($response['ResponseText']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <?php if (!$playerId): ?>
            <label>Votre Nom :</label>
            <input type="text" name="player_name" required>

            <label>Votre Email :</label>
            <input type="email" name="player_email" required>
        <?php else: ?>
            <input type="hidden" name="player_id" value="<?= $playerId ?>">
        <?php endif; ?>

        <button class="btn-submit" type="submit">Soumettre</button>
    </form>
</body>
</html>
