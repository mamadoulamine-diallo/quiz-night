<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quizz_night";

$conn = new mysqli($servername, $username, $password, $dbname);
session_start();

class Timer {
    public static function start() {
        $_SESSION['quiz_start_time'] = time();
    }

    public static function getRemainingTime() {
        if (!isset($_SESSION['quiz_start_time'])) {
            self::start();
        }
        $elapsed = time() - $_SESSION['quiz_start_time'];
        $remaining = 30 - $elapsed;
        
        if ($remaining <= 0) {
            return "00:00";
        }
        
        return sprintf("%02d:%02d", floor($remaining/60), $remaining % 60);
    }
}

class Question {
    private $id;
    private $text;
    private $answers;
    private $correctAnswer;

    public function __construct($id, $text, $answers, $correctAnswer) {
        $this->id = $id;
        $this->text = $text;
        $this->answers = $answers;
        $this->correctAnswer = $correctAnswer;
    }

    public function display() {
        ?>
        <div class="question"><?php echo htmlspecialchars($this->text); ?></div>
        
        <div class="timer"><?php echo Timer::getRemainingTime(); ?></div>
        
        <div class="answers-grid">
            <?php
            $letters = ['A', 'B', 'C', 'D'];
            foreach ($letters as $index => $letter) {
                if (isset($this->answers[$index])) {
                    ?>
                    <button type="submit" name="answer" value="<?php echo $letter; ?>" 
                            class="answer-button" form="quiz-form">
                        <?php echo $letter . ': ' . htmlspecialchars($this->answers[$index]); ?>
                    </button>
                    <?php
                }
            }
            ?>
        </div>

        <form id="quiz-form" method="post" action="verifier_reponse.php">
            <input type="hidden" name="question_id" value="<?php echo $this->id; ?>">
        </form>
        <?php
    }
}

class QuizManager {
    private $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=localhost;dbname=quizz_night;charset=utf8mb4",
                "root",
                "",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion: " . $e->getMessage());
        }
    }
    
    public function getCurrentQuestion() {
        $stmt = $this->pdo->query("
    SELECT q.QuestionID, q.QuestionText, 
           GROUP_CONCAT(a.ResponseText ORDER BY a.ResponseID) as answers
    FROM question q
    LEFT JOIN response a ON q.QuestionID = a.QuestionID
    WHERE q.QuestionID = 1
    GROUP BY q.QuestionID
");


        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            return new Question(
                $data['id'],
                $data['question_text'],
                explode(',', $data['answers']),
                $data['correct_answer']
            );
        }
        
        return null;
    }
}

// Réinitialiser le chronomètre si nouvelle question
if (!isset($_SESSION['quiz_start_time'])) {
    Timer::start();
}

// Créer l'instance du gestionnaire de quiz
$quizManager = new QuizManager();
$currentQuestion = $quizManager->getCurrentQuestion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz Night</title>
    <link rel="stylesheet" href="test.css">
    <meta http-equiv="refresh" content="1"> <!-- Pour mettre à jour le chronomètre -->
</head>
<body>
    <div class="quiz-header">
        <div class="brand">Quizz Night</div>
        <nav>
            <a href="accueil" class="nav-link">accueil</a>
            <a href="score" class="nav-link">score</a>
            <a href="compte" class="nav-button">Mon compte</a>
        </nav>
    </div>

    <div class="main-container">
        <div class="title-container">
            <h1>
                <span class="title-line1">QUESTIONS</span>
                <span class="title-line2">POUR UN</span>
                <span class="title-line3">Vainqueur</span>
            </h1>
        </div>

        <div class="quiz-container">
            <?php
            if ($currentQuestion) {
                $currentQuestion->display();
            } else {
                echo "<p>Aucune question disponible.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>