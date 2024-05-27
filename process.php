<?php
include 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $questions = $_SESSION['questions'];
    $currentQuestionIndex = $_SESSION['current_question'];
    $userAnswer = $_POST['answer'];
    $action = $_POST['action'];

    if ($userAnswer == $questions[$currentQuestionIndex]['answer']) {
        $_SESSION['score']++;
    }

    if ($action == 'stop' || $currentQuestionIndex == count($questions) - 1) {
        $score = $_SESSION['score'];
        $stmt = $conn->prepare("UPDATE users SET score = ? WHERE id = ?");
        $stmt->bind_param("ii", $score, $userId);
        $stmt->execute();
        $stmt->close();
        header('Location: leaderboard.php');
        exit();
    } else {
        $_SESSION['current_question']++;
        $nextQuestion = $questions[$_SESSION['current_question']]['question'];
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kuis</title>
</head>
<body>
    <h1>Kuis</h1>
    <form action="process.php" method="post">
        <p><?php echo $nextQuestion; ?></p>
        <input type="text" name="answer" required><br><br>
        <button type="submit" name="action" value="next">Next</button>
        <button type="submit" name="action" value="stop">Stop</button>
    </form>
</body>
</html>
