<?php
include 'database.php';

$result = $conn->query("SELECT name, class, phone, score FROM users ORDER BY score DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
</head>
<body>
    <h1>Leaderboard</h1>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Nomor Handphone</th>
            <th>Skor</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['score']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
