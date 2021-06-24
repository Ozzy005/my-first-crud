<?php

$dados = ($_POST);

if($dados['id']){
    $localhost = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'livro';
    $conn = mysqli_connect($localhost,$username,$password,$dbname);

    $sql = "UPDATE pessoa SET nome = '{$dados['nome']}',
                              endereco = '{$dados['endereco']}',
                              bairro = '{$dados['bairro']}',
                              telefone = '{$dados['telefone']}',
                              email = '{$dados['email']}',
                              id_cidade = '{$dados['id_cidade']}'
                              WHERE id = '{$dados['id']}'";

    $result = mysqli_query($conn,$sql);
    
    if($result){
        print "Registro atualizado com sucesso";
    }
    else{
        print mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
<button onclick="window.location='pessoa_list.php'">Voltar</button>