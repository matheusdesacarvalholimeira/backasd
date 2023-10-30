<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Conectar ao banco de dados (substitua com suas próprias configurações)
    $servername = "localhost";
    $username = "root";
    $password_db = "123456";
    $dbname = "meu_banco_de_dados";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para verificar as credenciais
        $stmt = $conn->prepare("SELECT senha FROM dados_do_formulario WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $hashedPassword = $row['senha'];

            if (password_verify($password, $hashedPassword)) {
                echo "Login bem-sucedido";
                header('location: login.html');
            } else {
                echo "Credenciais inválidas. Tente novamente.";
            }
        } else {
            echo "Credenciais inválidas. Tente novamente.";
        }
    } catch (PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
}else{
    header('location: login.html');
}
?>
