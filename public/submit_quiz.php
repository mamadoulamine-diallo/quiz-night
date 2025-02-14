<?php
session_start();

require_once __DIR__ . '/../classes/Player.php';
require_once __DIR__ . '/../classes/PlayerAnswer.php';
require_once __DIR__ . '/../classes/Response.php';

$playerObj = new Player();
$answerObj = new PlayerAnswer();
$responseObj = new Response();

$quizId = $_POST['quiz_id'] ?? null; 
$playerId = $_POST['player_id'] ?? $_SESSION['player_id'] ?? null;
$playerName = $_POST['player_name'] ?? null;
$playerEmail = $_POST['player_email'] ?? null;

if (!$playerId) { 
    $player = $playerObj->getPlayerByEmail($playerEmail);

    if (!$player) {
        $playerObj->addPlayer($playerName, $playerEmail);
        $player = $playerObj->getPlayerByEmail($playerEmail); 
    }

    $playerId = $player['PlayerID']; 
} else {
    $_SESSION['player_id'] = $playerId;
}

$score = 0;
foreach ($_POST as $key => $value) {
    if (strpos($key, "question_") === 0) {
        $questionId = str_replace("question_", "", $key);
        $responseId = $value;

        $answerObj->addPlayerAnswer($playerId, $quizId, $questionId, $responseId);

        $response = $responseObj->getResponsesByQuestion($questionId);
        foreach ($response as $resp) {
            if ($resp['ResponseID'] == $responseId && $resp['IsCorrect']) {
                $score++;
            }
        }
    }
}


$pdo = Database::getConnection();
$query = "INSERT INTO score (PlayerID, QuizID, Score, SubmittedAt) VALUES (:playerId, :quizId, :score, NOW())";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'playerId' => $playerId,
    'quizId' => $quizId,
    'score' => $score
]);

header("Location: leaderboard.php");
exit();
?>
