<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "crud_aula";

$conexao = new mysqli($host, $user, $password, $database);

if ($conexao->connect_error) {
    die("erro na conexão : " . $conexao->connect_error);
}


if (isset($_POST['cadastrar'])) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "INSERT INTO usuarios (nome, email) VALUES (? , ?)";
    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("ss", $nome, $email);
    $stmt->execute();

    header("location : index.php");
    exit();
}


if (isset($_GET['excluir'])) {

    $id = $_GET['excluir'];

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("location : index.php");
    exit();
}

if (isset($_POST['editar'])) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "UPDATE usuarios SET nome = ? , email = ?, WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssi", $nome, $email, $id);
    $stmt->execute();

    header("index.php");
    exit();
}


$sql = "SELECT id, nome, email FROM usuarios ORDER BY id DESC";
$resultado = $conexao->query($sql);


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD usuarios</title>
</head>

<body>

    <h1>Cadastro de usuarios</h1>

    <form method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <br><br>

        <label>Email : </label>
        <input type="text" name="email" required>

        <button type="submit" name="cadastrar">
            Cadastrar
        </button>
    </form>

    <h2>usuarios cadastrados</h2>
    <table border = "1">

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>acoes</th>
        </tr>

            <?php while ($usuario = $resultado -> fetch_assoc()){?>

                <tr>

                    <td>
                        <?=  $usuario['id'] ?>
                    </td>

                    <td>
                        <?=  $usuario['nome'] ?>
                    </td>

                    <td>
                        <?=  $usuario['email'] ?>
                    </td>

                    <td>

                        <a href="index.php?excluir=<?= $usuario['id'] ?>">
                            excluir
                        </a>

                    </td>

                </tr>

                <?php } ?>
            
    </table>
    
</body>

</html>