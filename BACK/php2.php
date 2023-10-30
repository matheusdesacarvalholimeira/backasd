<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=meu_banco_de_dados', 'root', '123456');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $nome = $_POST["name"];
        $email = $_POST["email"];
        $senha = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $stmt = $dbh->prepare("INSERT INTO dados_do_formulario (nome, email, senha) VALUES (:nome, :email, :senha)");

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();

        header('location: login.html');
    } catch (PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
} else {
    header('location: login.html');
}
?>
