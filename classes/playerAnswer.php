<?php
require_once __DIR__ . '/Database.php';

class PlayerAnswer {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Enregistrer la réponse d'un joueur
    public function addPlayerAnswer($playerId, $quizId, $questionId, $responseId) {
        $query = "INSERT INTO playeranswer (PlayerID, QuizID, QuestionID, ResponseID, SubmittedAt) 
                  VALUES (:playerId, :quizId, :questionId, :responseId, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'playerId' => $playerId,
            'quizId' => $quizId,
            'questionId' => $questionId,
            'responseId' => $responseId
        ]);
    }

    // Récupérer toutes les réponses d’un joueur pour un quiz donné
    public function getPlayerAnswers($playerId, $quizId) {
        $query = "SELECT * FROM playeranswer WHERE PlayerID = :playerId AND QuizID = :quizId";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'playerId' => $playerId,
            'quizId' => $quizId
        ]);
        return $stmt->fetchAll();
    }
}
?>
