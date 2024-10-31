<!-- PHP -->
<?php
/* Dados para conecar ao banco de dados */
$host = 'localhost'; // nome do servidor http
$username = 'root'; // nome de usuário para acessar mysql
$password = ''; // senha de acesso
$database = 'crudtasks_db'; // nome do banco de dados

/* Conexão com o banco de dados */
$conn = new mysqli($host, $username, $password, $database)
    or die("Não foi possível conectar: " . mysqli_error());

/* CREATE/UPDATE: Colocar nova tarefa ao banco de dados */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /* Adiciona cada item no formulário com o método post */
    $taskTitle = $_POST['taskTitle'];
    $taskTime = $_POST['taskTime'];
    $taskCategory = $_POST['taskCategory'];
    $taskColor = $_POST['taskColor'];
    $taskDescription = $_POST['taskDescription'];

    /* Adiciona os valores das váriaveis nas  células da tabela */
    $sql = "INSERT INTO crudtasks_table (taskTitle, taskTime, taskCategory, taskColor, taskDescription) 
    VALUES ('$taskTitle', '$taskTime', '$taskCategory', '$taskColor', '$taskDescription')"; 

    /* Retorna à página após criar/editar tarefa */
    if ($conn->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erro: " . mysqli_error();
    }
}

/* DELETE: deletar uma tarefa pegando o id usando o get */
if (isset($_GET['deletetaskId'])) {
    $taskId = $_GET['deletetaskId'];
    $sql = "DELETE FROM crudtasks_table WHERE id=$taskId"; // encontra id selecionado
    $conn->query($sql);
}

/* Função para leitura das tarefas */
function readtask($conn) {
    $sql = "SELECT * FROM crudtasks_table";
    return $conn->query($sql);
}

$crudtasks_table = readtask($conn);
?>

<!--HTML-->
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

<main>
<div class="container">
        <div class="row">
            <!-- Coluna da esquerda - Formulário -->
            <div class="col-md-6">
                <div class="text-center mt-4">
                    <button id="btn-taskForm" class="btn btn-primary btn-lg">+</button>
                </div>

                <!-- Formulário de tarefa -->
                <div id="taskFormContainer" class="task-container mt-4 p-4">
                    <form method="POST" id="taskForm">
                        <input type="hidden" name="editTaskId" id="editTaskId" value="">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label">Título da Tarefa</label>
                            <input type="text" class="form-control" name="taskTitle" id="taskTitle" placeholder="Nome da tarefa" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskTime" class="form-label">Tempo (formato hh:mm)</label>
                            <input type="time" class="form-control" name="taskTime" id="taskTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskCategory" class="form-label">Categoria</label>
                            <input type="text" class="form-control" name="taskCategory" id="taskCategory" placeholder="Ex: Trabalho, Lazer" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskColor" class="form-label">Cor da Tarefa</label>
                            <input type="color" class="form-control form-control-color" name="taskColor" id="taskColor" value="#000000">
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Descrição (opcional)</label>
                            <textarea class="form-control" name="taskDescription" id="taskDescription" placeholder="Descrição da tarefa"></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom">Adicionar Tarefa</button>
                    </form>
                </div>
            </div>

            <!-- Coluna da direita - Lista de Tarefas -->
            <div class="col-md-6">
                <div class="task-container mt-4 p-4">
                    <h2>Suas Tarefas</h2>
                    <ul class="list-group" id="taskList">
                        <?php
                            /* Exibe as tarefas em forma de lista */
                            if ($crudtasks_table->num_rows > 0) { // Verifica a tabela possui pelo menos um registro
                                while ($row = $crudtasks_table->fetch_assoc()) { // A função fetch_assoc() retorna cada linha
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:' . $row['taskColor'] . ';">';
                                    echo '<div>';
                                    echo '<span class="fw-bold">' . $row['taskTitle'] . '</span> - <span class="text-muted">' . $row['taskCategory'] . '</span><br>';
                                    echo '<span>' . $row['taskTime'] . '</span> - ' . ($row['taskDescription'] ? '<small>' . $row['taskDescription'] . '</small>' : '');
                                    echo '</div>';
                                    echo '<div>';
                                    echo '<button class="btn btn-edit btn-sm btn-secondary" data-id="' . $row['id'] . '" data-title="' . $row['taskTitle'] . '" data-time="' . $row['taskTime'] . '" data-category="' . $row['taskCategory'] . '" data-color="' . $row['taskColor'] . '" data-description="' . $row['taskDescription'] . '">Editar</button>';
                                    echo '<a href="?removeTaskId=' . $row['id'] . '" class="btn btn-danger btn-sm ms-2">Remover</a>';
                                    echo '</div>';
                                    echo '</li>';
                                }
                            } else {
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
    // Script para mostrar/ocultar o formulário
    document.getElementById('btn-taskForm').addEventListener('click', function() {
        var formContainer = document.getElementById('taskFormContainer');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    });
</script>

</body>
</html>