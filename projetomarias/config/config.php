<?php
// Inclui o arquivo da classe Database (se necessário)
include_once "./classes/Database.php"; 

// Verifica se a classe Database está sendo usada
if (class_exists('Database')) {
    // Usa a classe Database para obter a conexão
    $database = new Database(); 
    $db = $database->getConnection();
} else {
    // Caso contrário, cria a conexão manualmente
    try {
        $db = new PDO("mysql:host=localhost;dbname=bdcrud", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}
?>