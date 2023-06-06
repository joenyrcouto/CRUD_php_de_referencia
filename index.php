<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD com PHP</title>
    <!-- Adicionando os arquivos CSS do framework Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        .container {
            margin-top: 50px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center;">CRUD com PHP</h1>
        <hr>

        <div class="form-container">
            <?php
            $host = 'localhost';
            $port = '3306';
            $dbname = 'aula';
            $username = 'root';
            $password = '';

            // Conexão com o banco de dados
            $conexao = mysqli_connect($host, $username, $password, $dbname, $port);
            if (!$conexao) {
                die('Falha na conexão com o banco de dados: ' . mysqli_connect_error());
            } else {
                echo '<div class="alert alert-success">Conexão com o banco de dados estabelecida!</div>';
            }

            // Operação de Inserção
            if (isset($_POST['insert'])) {
                $matricula = $_POST['matr'];
                $nome = $_POST['nome'];
                
                // Verifica se a matrícula já existe
                $selectQuery = "SELECT matr FROM aluno WHERE matr = '$matricula'";
                $result = mysqli_query($conexao, $selectQuery);
                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="alert alert-danger">Erro ao inserir registro: Matrícula já existente</div>';
                } else {
                    $insertQuery = "INSERT INTO aluno (matr, nome) VALUES ('$matricula', '$nome')";
                    if (mysqli_query($conexao, $insertQuery)) {
                        echo '<div class="alert alert-success">Registro inserido com sucesso!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Erro ao inserir registro: ' . mysqli_error($conexao) . '</div>';
                    }
                }
            }

            // Operação de Leitura
            if (isset($_POST['read'])) {
                $matricula = $_POST['matr'];
                $selectQuery = "SELECT nome FROM aluno WHERE matr = '$matricula'";
                $result = mysqli_query($conexao, $selectQuery);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $nome = $row['nome'];
                } else {
                    echo '<div class="alert alert-warning">Registro não encontrado</div>';
                    $nome = "";
                }
            }

            // Operação de Atualização
            if (isset($_POST['update'])) {
                $matricula = $_POST['matr'];
                $nome = $_POST['nome'];
                $updateQuery = "UPDATE aluno SET nome = '$nome' WHERE matr = '$matricula'";
                if (mysqli_query($conexao, $updateQuery)) {
                    echo '<div class="alert alert-success">Registro atualizado com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao atualizar registro: ' . mysqli_error($conexao) . '</div>';
                }
            }

            // Operação de Exclusão
            if (isset($_POST['delete'])) {
                $matricula = $_POST['matr'];
                $deleteQuery = "DELETE FROM aluno WHERE matr = '$matricula'";
                if (mysqli_query($conexao, $deleteQuery)) {
                    echo '<div class="alert alert-success">Registro excluído com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao excluir registro: ' . mysqli_error($conexao) . '</div>';
                }
            }

            // Listagem dos registros existentes
            $selectAllQuery = "SELECT * FROM aluno";
            $result = mysqli_query($conexao, $selectAllQuery);
            if (mysqli_num_rows($result) > 0) {
                echo '<h2>Registros existentes:</h2>';
                echo '<table class="table">';
                echo '<thead class="thead-light">';
                echo '<tr>';
                echo '<th scope="col">Matrícula</th>';
                echo '<th scope="col">Nome</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['matr'] . '</td>';
                    echo '<td>' . $row['nome'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'Nenhum registro encontrado';
            }

            // Fechando a conexão com o banco de dados
            mysqli_close($conexao);
            ?>

            <form method="post" class="mt-3">
                <div class="form-group">
                    <label for="matricula">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" name="matr" value="<?php echo isset($matricula) ? $matricula : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($nome) ? $nome : ''; ?>">
                </div>
                <div class="btn-group" role="group">
                    <button type="submit" name="insert" class="btn btn-primary">Inserir</button>
                    <button type="submit" name="read" class="btn btn-primary">Ler</button>
                    <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                    <button type="submit" name="delete" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Adicionando os arquivos JavaScript do framework Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
