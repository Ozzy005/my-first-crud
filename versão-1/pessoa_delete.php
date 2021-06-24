<?php

$dados = $_GET;

if(!empty($dados['id'])){
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'livro';

    $conn = mysqli_connect($hostname,$username,$password,$dbname);
    $sql = "DELETE FROM pessoa where id = '{$dados['id']}'";

    $result = mysqli_query($conn,$sql);

    if($result){
        print 'Registro excluído com sucesso';
    }
    else{
        print mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
<button onclick="window.location='pessoa_list.php'">Voltar</button>