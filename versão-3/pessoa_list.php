<?php
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);

    if(!empty($_GET['action']) && $_GET['action'] == 'delete'){
        $id = (int)$_GET['id'];
        $sql_delete = "DELETE FROM pessoa WHERE id = '{$id}'";
        mysqli_query($conn,$sql_delete);
    }

    $sql_select = "SELECT * FROM pessoa ORDER BY id";
    $result = mysqli_query($conn,$sql_select);
    $itens = '';
    while ($row = mysqli_fetch_assoc($result)){
        $item = file_get_contents('html/item.html');
        $item = str_replace('{id}',$row['id'],$item);
        $item = str_replace('{nome}',$row['nome'],$item);
        $item = str_replace('{endereco}',$row['endereco'],$item);
        $item = str_replace('{bairro}',$row['bairro'],$item);
        $item = str_replace('{telefone}',$row['telefone'],$item);
        $itens .= $item;

    }
    $list = file_get_contents('html/list.html');
    $list = str_replace('{itens}',$itens,$list);
    print $list;
?>