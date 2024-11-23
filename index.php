<?php
// Carregar as tarefas do arquivo JSON
$tasksFile = 'tasks.json';
$tasks = file_exists($tasksFile) ? json_decode(file_get_contents($tasksFile), true) : [];

// Adicionar uma nova tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $newTask = htmlspecialchars($_POST['task']);
    $tasks[] = $newTask;
    file_put_contents($tasksFile, json_encode($tasks));
    header("Location: index.php");
    exit;
}

// Excluir uma tarefa
if (isset($_GET['delete'])) {
    $taskIndex = (int) $_GET['delete'];
    if (isset($tasks[$taskIndex])) {
        array_splice($tasks, $taskIndex, 1);
        file_put_contents($tasksFile, json_encode($tasks));
    }
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="todo-container">
        <h1>TODO List</h1>
        <form method="POST" action="">
            <input type="text" name="task" class="todo-input" placeholder="Adicione uma tarefa..." required>
            <button type="submit" class="add-btn">Adicionar</button>
        </form>
        <ul id="todo-list">
            <?php foreach ($tasks as $index => $task): ?>
                <li>
                    <span><?php echo $task; ?></span>
                    <a href="?delete=<?php echo $index; ?>" class="delete-btn">Excluir</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
