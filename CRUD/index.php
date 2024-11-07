<!-- PHP -->
<?php
/* Dados para conecar ao banco de dados */
$host = 'localhost'; // nome do servidor http
$username = 'root'; // nome de usuário para acessar mysql
$password = ''; // senha de acesso
$database = 'crudtasks_db'; // nome do banco de dados

/* Conexão com o servidor */
$conn = new mysqli($host, $username, $password, $database)
    if ($conn->connect_error) {
        die("Não foi possível se conectar: " . $conn->connect_error);
    }

/* CREATE/UPDATE: Colocar nova tarefa no banco de dados */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /* Adiciona cada item do formulário com o método post */
    $taskId = $_POST['taskId'];
    $taskTitle = $_POST['taskTitle'];
    $taskTime = $_POST['taskTime'];
    $taskCategory = $_POST['taskCategory'];
    $taskColor = $_POST['taskColor'];
    $taskDescription = $_POST['taskDescription'];

    /* Adiciona os valores presentes nas variáveis nas células da tabela */
    if ($taskId) { // UPDATE: editar uma tarefa já existente
        $sql = "UPDATE crudtasks_table 
                SET taskTitle='$taskTitle', taskTime='$taskTime', taskCategory='$taskCategory', 
                    taskColor='$taskColor', taskDescription='$taskDescription' 
                WHERE id=$taskId";
    } else { // CREATE: criar uma tarefa
        $sql = "INSERT INTO crudtasks_table (taskTitle, taskTime, taskCategory, taskColor, taskDescription) 
                VALUES ('$taskTitle', '$taskTime', '$taskCategory', '$taskColor', '$taskDescription')";
    }

    /* Retorna à página após criar/editar tarefa */
    if ($conn->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<p>Erro ao salvar a tarefa: " . $conn->error . "</p>";
    }
}

/* DELETE: deletar uma tarefa */
if (isset($_GET['deletetaskId'])) { // função que verifica o id
    $taskId = $_GET['deletetaskId'];
    $sql = "DELETE FROM crudtasks_table WHERE id=$taskId";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* READ: Função para leitura das tarefas */
function readtask($conn) {
    $sql = "SELECT * FROM crudtasks_table";
    return $conn->query($sql);
}

$crudtasks_table = readtask($conn);
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sparklist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<header class="custom-header">
    <div class="container d-flex justify-content-end align-items-center">
        <div class="logo">
            <img src="media/images/sparklist-logo.png" alt="logo">
        </div>
    </div>
</header>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-12 p-4" style="background-color: #4b2c77; border-radius: 8px;">
            <div class="row">
                <!-- Formulário -->
                <div class="col-md-6 p-3">
                    <form method="POST">
                        <input type="hidden" name="taskId" id="taskId" value="">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label">Título da Tarefa</label>
                            <input type="text" name="taskTitle" id="taskTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskTime" class="form-label">Tempo (formato hh:mm)</label>
                            <input type="time" name="taskTime" id="taskTime" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskCategory" class="form-label">Categoria</label>
                            <input type="text" name="taskCategory" id="taskCategory" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskColor" class="form-label">Cor da Tarefa</label>
                            <input type="color" name="taskColor" id="taskColor" class="form-control form-control-color" value="#000000">
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Descrição (opcional)</label>
                            <textarea name="taskDescription" id="taskDescription" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Adicionar Tarefa</button>
                    </form>
                </div>

                <!-- Lista de Tarefas -->
                <div class="col-md-6 p-3">
                    <h2 class="text-center">Suas Tarefas</h2>
                    <ul class="list-group">
                        <?php
                        if ($crudtasks_table->num_rows > 0) { // Se houver pelo menos uma linha na tabela, o que está abaixo é mostrado
                            while ($row = $crudtasks_table->fetch_assoc()) {
                                echo '<li class="list-group-item d-flex justify-content-between align-items-start" style="background-color:' . $row['taskColor'] . ';">';
                                echo '<div>';
                                echo '<span class="fw-bold">' . $row['taskTitle'] . '</span> - <span class="text-muted">' . $row['taskCategory'] . '</span><br>';
                                echo '<small class="text-secondary">' . $row['taskTime'] . '</small> - ' . ($row['taskDescription'] ? '<small class="text-secondary">' . $row['taskDescription'] . '</small>' : '');
                                echo '</div>';
                                echo '<div>';
                                echo '<button class="btn btn-sm btn-outline-secondary btn-edit me-2" data-id="' . $row['id'] . '" data-title="' . $row['taskTitle'] . '" data-time="' . $row['taskTime'] . '" data-category="' . $row['taskCategory'] . '" data-color="' . $row['taskColor'] . '" data-description="' . $row['taskDescription'] . '">Editar</button>';
                                echo '<a href="?deletetaskId=' . $row['id'] . '" class="btn btn-sm btn-outline-danger">Deletar</a>';
                                echo '</div>';
                                echo '</li>';
                            }
                        } else { // Senão, nenhuma tarefa foi encontrada.
                            echo '<li class="list-group-item">Nenhuma tarefa encontrada.</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Preencher formulário com dados da tarefa para edição
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('taskId').value = this.dataset.id;
            document.getElementById('taskTitle').value = this.dataset.title;
            document.getElementById('taskTime').value = this.dataset.time;
            document.getElementById('taskCategory').value = this.dataset.category;
            document.getElementById('taskColor').value = this.dataset.color;
            document.getElementById('taskDescription').value = this.dataset.description;
        });
    });
</script>
</body>
</html>
