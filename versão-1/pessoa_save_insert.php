<?php

$dados = ($_POST);

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'livro';

$conn = mysqli_connect($host,$username,$password,$dbname);

$sql_select = "SELECT max(id) as next FROM pessoa";
$result = mysqli_query($conn,$sql_select);

$next = (int)mysqli_fetch_assoc($result)['next']+1;

$sql_insert = "INSERT INTO pessoa (id,
                            nome,
                            endereco,
                            bairro,
                            telefone,
                            email,
                            id_cidade)
                            VALUES ('{$next}',
                            '{$dados['nome']}',
                            '{$dados['endereco']}',
                            '{$dados['bairro']}',
                            '{$dados['telefone']}',
                            '{$dados['email']}',
                            '{$dados['id_cidade']}'
                            )";

$result = mysqli_query($conn,$sql_insert);

if($result){
    print "Registro inserido com sucesso";
}
else{
    print mysqli_error($conn);
}
mysqli_close($conn);
?>
<button onclick="window.location='pessoa_form_insert.php'">Voltar</button>