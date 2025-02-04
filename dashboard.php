<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['tasks'])) $_SESSION['tasks'] = [];
    $newTask = htmlspecialchars($_POST['task']);
    if (!empty($newTask)) $_SESSION['tasks'][] = ['task' => $newTask, 'completed' => false];
}
if (isset($_GET['delete'])) unset($_SESSION['tasks'][$_GET['delete']]);
if (isset($_GET['complete'])) $_SESSION['tasks'][$_GET['complete']]['completed'] = true;
$totalTasks = count($_SESSION['tasks']);
$completedTasks = count(array_filter($_SESSION['tasks'], fn($task) => $task['completed']));
$progress = $totalTasks ? ($completedTasks / $totalTasks) * 100 : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="theme.js" defer></script>
</head>
<body class="fun-background">
    <div class="container">
        <h1>Your Dashboard</h1>
        <form method="POST">
            <input type="text" name="task" placeholder="Enter a new task" required>
            <button type="submit">Add Task</button>
        </form>
        <h2>Task Progress</h2>
        <div class="progress-bar">
            <div class="progress" style="width: <?= $progress; ?>%;"></div>
        </div>
        <p><?= $completedTasks; ?> of <?= $totalTasks; ?> tasks completed</p>
        <ul>
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li class="<?= $task['completed'] ? 'completed' : ''; ?>">
                    <?= $task['task']; ?>
                    <a href="?complete=<?= $index; ?>">✔</a>
                    <a href="?delete=<?= $index; ?>">❌</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="index.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
