<?php
// Simple Todo App with SQLite

// Database connection
try {
    $pdo = new PDO('sqlite:todos.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (!empty($_POST['task'])) {
                    $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (?)");
                    $stmt->execute([$_POST['task']]);
                }
                break;
            case 'toggle':
                if (isset($_POST['id'])) {
                    $stmt = $pdo->prepare("UPDATE todos SET completed = NOT completed WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                }
                break;
            case 'delete':
                if (isset($_POST['id'])) {
                    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                }
                break;
        }
        header('Location: index.php');
        exit;
    }
}

// Get all todos
$stmt = $pdo->query("SELECT * FROM todos ORDER BY created_at DESC");
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Todo App</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .add-form {
            padding: 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .input-group input {
            flex: 1;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #e53e3e;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
        }

        .btn-danger:hover {
            background: #c53030;
        }

        .todo-list {
            padding: 20px;
        }

        .todo-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            margin-bottom: 10px;
            background: white;
            transition: all 0.3s ease;
        }

        .todo-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .todo-item.completed {
            background: #f8f9fa;
            opacity: 0.7;
        }

        .todo-item.completed .todo-text {
            text-decoration: line-through;
            color: #6c757d;
        }

        .todo-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 15px;
            cursor: pointer;
        }

        .todo-text {
            flex: 1;
            font-size: 16px;
            cursor: pointer;
        }

        .todo-date {
            font-size: 12px;
            color: #6c757d;
            margin-right: 15px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state h3 {
            margin-bottom: 10px;
        }

        .stats {
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Mi Lista de Tareas</h1>
            <p>Gestiona tus tareas de forma sencilla</p>
        </div>

        <form method="POST" class="add-form">
            <input type="hidden" name="action" value="add">
            <div class="input-group">
                <input type="text" name="task" placeholder="¿Qué necesitas hacer?" required>
                <button type="submit" class="btn btn-primary">Agregar Tarea</button>
            </div>
        </form>

        <div class="todo-list">
            <?php if (empty($todos)): ?>
                <div class="empty-state">
                    <h3>🎯 No hay tareas pendientes</h3>
                    <p>¡Agrega tu primera tarea arriba!</p>
                </div>
            <?php else: ?>
                <?php foreach ($todos as $todo): ?>
                    <div class="todo-item <?= $todo['completed'] ? 'completed' : '' ?>">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                            <input type="checkbox"
                                   class="todo-checkbox"
                                   <?= $todo['completed'] ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                        </form>
                        <span class="todo-text" onclick="toggleTodo(<?= $todo['id'] ?>)">
                            <?= htmlspecialchars($todo['task']) ?>
                        </span>
                        <span class="todo-date">
                            <?= date('d/m/Y', strtotime($todo['created_at'])) ?>
                        </span>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="stats">
            <?php
            $total = count($todos);
            $completed = count(array_filter($todos, fn($t) => $t['completed']));
            $pending = $total - $completed;
            ?>
            Total: <?= $total ?> | Completadas: <?= $completed ?> | Pendientes: <?= $pending ?>
        </div>
    </div>

    <script>
        function toggleTodo(id) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" name="id" value="${id}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>