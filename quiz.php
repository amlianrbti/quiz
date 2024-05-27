<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO users (name, class, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $class, $phone);
    $stmt->execute();

    $userId = $stmt->insert_id;
    $stmt->close();
} else {
    die("Invalid request.");
}

session_start();
$_SESSION['user_id'] = $userId;
$_SESSION['score'] = 0;

$questions = [
    ["question" => "What is 2 + 2?", "answer" => 4],
    ["question" => "What is the capital of France?", "answer" => "Paris"],
    ["question" => "What is the color of the sky?", "answer" => "Blue"]
];

$_SESSION['questions'] = $questions;
$_SESSION['current_question'] = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kuis</title>
</head>
<body>
    <h1>Kuis</h1>
    <form action="process.php" method="post">
        <p><?php echo $questions[0]['question']; ?></p>
        <input type="text" name="answer" required><br><br>
        <button type="submit" name="action" value="next">Next</button>
        <button type="submit" name="action" value="stop">Stop</button>
    </form>
</body>
</html>
