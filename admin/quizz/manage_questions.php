<?php

require_once __DIR__ . '/../auth/auth.php';

require_once __DIR__ . '/../../classes/Question.php';
require_once __DIR__ . '/../../classes/Response.php';



$quizId = $_GET['quizId'] ?? null;
if (!$quizId) {
    header("Location: index.php");
    exit();
}

$questionObj = new Question();
$responseObj = new Response();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_question'])) {
        $questionText = $_POST['question_text'];
        if (!empty($questionText)) {
            $questionObj->addQuestion($quizId, $questionText);
        }
    } elseif (isset($_POST['add_response'])) {
        $questionId = $_POST['question_id'];
        $responseText = $_POST['response_text'];
        $isCorrect = isset($_POST['is_correct']) ? 1 : 0;
        if (!empty($responseText)) {
            $responseObj->addResponse($questionId, $responseText, $isCorrect);
        }
    }
}

$questions = $questionObj->getQuestionsByQuizId($quizId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Questions</title>
</head>
<body>
    <h2>Gestion des Questions pour le Quiz</h2>
    
    <form action="" method="POST">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
        <label>Nouvelle Question :</label>
        <input type="text" name="question_text" required>
        <button type="submit" name="add_question">Ajouter Question</button>
    </form>

    <h3>Questions Existantes</h3>
    <ul>
        <?php foreach ($questions as $q): ?>
            <li>
                <strong><?= htmlspecialchars($q['QuestionText']) ?></strong>
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="question_id" value="<?= $q['QuestionID'] ?>">
                    <input type="text" name="response_text" required>
                    <label>Bonne Réponse : <input type="checkbox" name="is_correct"></label>
                    <button type="submit" name="add_response">Ajouter Réponse</button>
                </form>
                <ul>
                    <?php 
                    $responses = $responseObj->getResponsesByQuestion($q['QuestionID']);
                    foreach ($responses as $r): ?>
                        <li><?= htmlspecialchars($r['ResponseText']) ?> <?= $r['IsCorrect'] ? "(✔️ Correct)" : "" ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="../index.php">Retour</a>
</body>
</html>
