<?php

function lista_pessoas(){
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = "SELECT * FROM pessoa ORDER BY id";
    $result = mysqli_query($conn,$sql);
    $list = mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_close($conn);
    return $list;
}

function exclui_pessoa($id){
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = "DELETE FROM pessoa WHERE id = '{$id}'";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    return $result;
}

function get_pessoa($id){
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = "SELECT * FROM pessoa WHERE id = '{$id}'";
    $result = mysqli_query($conn,$sql);
    $pessoa = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $pessoa;
}
function get_next_pessoa(){
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = "SELECT max(id) as next from pessoa";
    $result = mysqli_query($conn,$sql);
    $next = (int)mysqli_fetch_assoc($result)['next']+1;
    mysqli_close($conn);
    return $next;
}
function insert_pessoa($pessoa){
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = "INSERT INTO pessoa (id,nome,endereco,bairro,telefone,email,
    id_cidade) VALUES ('{$pessoa['id']}','{$pessoa['nome']}','{$pessoa['endereco']}',
    '{$pessoa['bairro']}','{$pessoa['telefone']}','{$pessoa['email']}',
    '{$pessoa['id_cidade']}')";
    $result = mysqli_query($conn,$sql);
    $result = $result?"REGISTRO N°{$pessoa['id']} INSERIDO":'Erro no cadastro';
    mysqli_close($conn);
    return $result;
}
function update_pessoa($pessoa){
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = "UPDATE pessoa SET nome = '{$pessoa['nome']}',
    endereco = '{$pessoa['endereco']}', bairro = '{$pessoa['bairro']}',
    telefone = '{$pessoa['telefone']}',email = '{$pessoa['email']}',
    id_cidade = '{$pessoa['id_cidade']}' WHERE id = '{$pessoa['id']}'";
    $result = mysqli_query($conn,$sql);
    $result = $result?"REGISTRO N°{$pessoa['id']} ALTERADO":'Erro na alteração';
    mysqli_close($conn);
    return $result;
}
function lista_combo_cidades($id = null){

    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = 'SELECT id,nome FROM cidade';
    $result = mysqli_query($conn,$sql);

    $cidades = '';
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $selected = ($row['id'] == $id)?'selected':'';
            $cidades .= "<option value='{$row['id']}' $selected>{$row['nome']}</option>\n"; 
        }
    }
    mysqli_close($conn);
    return $cidades;
}
function lista_cidade($id){
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
    $sql = "SELECT nome FROM cidade WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    $cidade = mysqli_fetch_assoc($result);
    $cidade = $cidade['nome'];
    return $cidade;
}


?>