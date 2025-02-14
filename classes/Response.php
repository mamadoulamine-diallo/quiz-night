<?php
require_once __DIR__ . '/Database.php';

class Response {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addResponse($questionId, $text, $isCorrect) {
        $query = "INSERT INTO response (QuestionID, ResponseText, IsCorrect) VALUES (:questionId, :ResponseText, :isCorrect)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'questionId' => $questionId,
            'ResponseText' => $text,
            'isCorrect' => $isCorrect
        ]);
    }

    public function updateResponse($responseId, $text, $isCorrect) {
        $query = "UPDATE response SET Text = :text, IsCorrect = :isCorrect WHERE ResponseID = :responseId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'text' => $text,
            'isCorrect' => $isCorrect,
            'responseId' => $responseId
        ]);
    }

    public function deleteResponse($responseId) {
        $query = "DELETE FROM response WHERE ResponseID = :responseId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['responseId' => $responseId]);
    }

    public function getResponsesByQuestion($questionId) {
        $query = "SELECT * FROM response WHERE QuestionID = :questionId";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['questionId' => $questionId]);
        return $stmt->fetchAll();
    }
}
?>
