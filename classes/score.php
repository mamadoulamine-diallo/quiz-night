<?php
require_once __DIR__ . '/Database.php';

class Score {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Calculer le score d'un joueur pour un quiz donné
    public function calculateScore($playerId, $quizId) {
        $query = "
            SELECT COUNT(*) as score 
            FROM playeranswer pa
            JOIN response r ON pa.ResponseID = r.ResponseID
            WHERE pa.PlayerID = :playerId AND pa.QuizID = :quizId AND r.IsCorrect = 1
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'playerId' => $playerId,
            'quizId' => $quizId
        ]);
        $result = $stmt->fetch();
        return $result ? $result['score'] : 0;
    }

    // Enregistrer le score dans la bd
    public function saveScore($playerId, $quizId, $score) {
        $query = "INSERT INTO score (PlayerID, QuizID, Score, SubmittedAt) 
                  VALUES (:playerId, :quizId, :score, NOW())
                  ON DUPLICATE KEY UPDATE Score = :score, SubmittedAt = NOW()";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'playerId' => $playerId,
            'quizId' => $quizId,
            'score' => $score
        ]);
    }

    // Récupérer le score d'un joueur pour un quiz
    public function getScore($playerId, $quizId) {
        $query = "SELECT Score FROM score WHERE PlayerID = :playerId AND QuizID = :quizId";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'playerId' => $playerId,
            'quizId' => $quizId
        ]);
        return $stmt->fetch();
    }
}
?>
