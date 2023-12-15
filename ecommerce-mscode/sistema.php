
<?php 
include 'config.php';
session_start();
$id_usuario = $_SESSION['email'];

if (!isset($id_usuario)){
    header('Location: login.php');
}


// PUXANDO DO BANCO DE DADOS AS INFORMAÇÕES E MOSTRANDO NA TELA


if(isset($_POST['add_carrinho'])){
    $nome_produto = mysqli_real_escape_string($conn, $_POST['nome_produto']);
    $preco_produto = mysqli_real_escape_string($conn, $_POST['preco_produto']);
    $imagem_produto = mysqli_real_escape_string($conn, $_POST['imagem_produto']);
    $quantidade_produto = mysqli_real_escape_string($conn, $_POST['quantidade_produto']);

    $select_carrinho = mysqli_query($conn, "SELECT * FROM carrinho WHERE nome = '$nome_produto' AND id_cliente = '$id_usuario'");

    if (mysqli_num_rows($select_carrinho) > 0 ) {
        $mensagem[] = 'Produto já foi adicionado !';
    } else {
        mysqli_query($conn, "INSERT INTO carrinho(id_cliente,  nome, preco, imagem, quantidade) VALUES('$id_usuario','$nome_produto',
        '$preco_produto','$imagem_produto','$quantidade_produto')");
        $mensagem[] = 'Produto inserido no carrinho !';
    }
}
// PARTE DE ADICIONAR NO CARRINHO

if (isset($_POST['atualiza_carrinho'])) {
    $atualiza_quantidade = $_POST['quantidade_carrinho'];
    $atualiza_id = $_POST['atualiza_id'];
    mysqli_query($conn, "UPDATE `carrinho` SET quantidade = '$atualiza_quantidade' WHERE id = '$atualiza_id'");
}


// PARTE DE REMOVER DO CARRINHO

if (isset($_GET['deleteitem'])) {
    $remove_id = $_GET['carrinho_id'];
    mysqli_query($conn, "DELETE FROM `carrinho`  WHERE id = '$remove_id'");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="sistema.css">
    <title>Projeto MsCode</title>
</head>
<body>
    <?php 
        echo "Bem Vindo  " . $_SESSION['email'];
    ?>
    <header>
        <h1>TecnoMind</h1>
        <a href='login.php'>sair</a>
    </header>

    <h1>Produtos Disponiveis</h1>
    <div class="produtos">
        <div class="box-container">
            <?php 
                $select_produtos = mysqli_query($conn,"SELECT * FROM produtos");
                if (mysqli_num_rows($select_produtos) > 0){
                    while ($fetch_produtos = mysqli_fetch_assoc($select_produtos)){

            ?>
            <form action="" method="POST" class="box">
                <img src="<?php echo $fetch_produtos['imagem']; ?>">
                <div class="nome"><?php echo $fetch_produtos['nome']; ?></div>
                <div class="nome"><?php echo $fetch_produtos['preco']; ?></div>
                <input type="number" name="quantidade_produto" min="1" value="1">
                <input type="hidden" name="imagem_produto" value="<?php echo $fetch_produtos['imagem']; ?>">
                <input type="hidden" name="nome_produto" value="<?php echo $fetch_produtos['nome']; ?>">
                <input type="hidden" name="preco_produto" value="<?php echo $fetch_produtos['preco']; ?>">
                <input type="submit"  value="Adiciona no carrinho" name="add_carrinho" >
            </form>

            <?php
                    };
                };

            ?>  
        </div>
                                                    
    </div>
    
    <h1>Carrinho de Compras</h1>
    <div class="carrinho">

        <table>
            <thead>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
                <th>Ação</th>
            </thead>
            <tbody>
                <?php
                    $valor_total = 0;
                    $consulta_carrinho = mysqli_query($conn,"SELECT * FROM carrinho WHERE id_cliente = '$id_usuario'") or die('A consulta falhou');
                    if (mysqli_num_rows($consulta_carrinho) > 0){
                        while ($fetch_carrinho = mysqli_fetch_assoc($consulta_carrinho)) {
                ?>
                
                <tr>
                    <td><img src="imagens/<?php echo $fetch_carrinho['imagem']; ?>" height="100" alt=""></td>
                    <td><?php echo $fetch_carrinho['nome'];?> </td>
                    <td>R$ <?php echo $fetch_carrinho['preco'];?> </td>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="atualiza_id" value="<?php echo $fetch_carrinho['id']; ?>">
                            <input type="number" name="quantidade_carrinho" min="1" value="<?php echo $fetch_carrinho['quantidade']; ?>">
                            <input type="submit" name="atualiza_carrinho" value="Atualiza">
                        </form>
                    </td>
                    <td>R$ <?php echo $valor_item = (intval($fetch_carrinho['preco']) * $fetch_carrinho['quantidade']); ?></td>
                    <td><a href="sistema.php?deleteitem=1&carrinho_id=<?php echo $fetch_carrinho['id'];?>" class="delete-btn" onclick="return confirm('Deseja deletar item?');"></td>
                </tr>

                <?php 
                $valor_total += $valor_item;
                    };
                }else{
                    echo '<tr><td>Nenhum item adicioando</td></tr>';
                }
                ?>

                <tr>
                    <td>TOTAL:</td>
                    <td>R$<?php echo $valor_total; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body> 
</html>