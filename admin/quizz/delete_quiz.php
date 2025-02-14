<?php 
require_once __DIR__ . '/../../classes/Quiz.php';require_once __DIR__ . '/../auth/auth.php';

if (!isset($_GET['id'])) {
  die("Erreur : ID du quiz manquant.");
}

$quizId = $_GET['id'];
$quiz = new Quiz();

if ($quiz->deleteQuiz($quizId)) {
  header("Location: ../index.php?message=Quiz supprimé avec succès !");
exit();

} else {
  echo "Erreur lors de la suppression du quiz.";

}
?>