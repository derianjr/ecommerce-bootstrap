<?php 

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ecomerce';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Falha na conexão com o banco de dados: ' . $conn->connect_error);  
}
    
?>