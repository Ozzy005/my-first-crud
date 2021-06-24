<?php
if(!empty($_REQUEST['action'])){
        
    $dsn = array('host'=>'localhost','user'=>'root','pw'=>'','db'=>'livro');
    $conn = mysqli_connect($dsn['host'],$dsn['user'],$dsn['pw'],$dsn['db']);
        
    if($_REQUEST['action'] == 'edit'){
        $id = (int)$_GET['id'];
        $sql_select = "SELECT * FROM pessoa WHERE id='{$id}'";
        $result = mysqli_query($conn,$sql_select);
                    
        $pessoa = mysqli_fetch_assoc($result);
        $resultado = '';
    }
    elseif($_REQUEST['action'] == 'save'){
        $pessoa = $_POST;
    
        if(empty($pessoa['id'])){
            $sql_select = "SELECT max(id) as next FROM pessoa";
            $result = mysqli_query($conn,$sql_select);
            $next =(int)mysqli_fetch_assoc($result)['next']+1;
    
            $sql_insert = "INSERT INTO pessoa (id,nome,endereco,bairro,telefone,email,
            id_cidade) VALUES ('{$next}','{$pessoa['nome']}','{$pessoa['endereco']}',
            '{$pessoa['bairro']}','{$pessoa['telefone']}','{$pessoa['email']}',
            '{$pessoa['id_cidade']}')";
            $result = mysqli_query($conn,$sql_insert);

            $resultado = $result?"REGISTRO N°$next INSERIDO":mysqli_error($conn);
            mysqli_close($conn);
        }
        else{
            $sql_update = "UPDATE pessoa SET nome = '{$pessoa['nome']}',
            endereco = '{$pessoa['endereco']}', bairro = '{$pessoa['bairro']}',
            telefone = '{$pessoa['telefone']}',
            email = '{$pessoa['email']}',id_cidade = '{$pessoa['id_cidade']}'
            WHERE id = '{$pessoa['id']}'";
            $result = mysqli_query($conn,$sql_update);

            $resultado = $result?"REGISTRO N°{$pessoa['id']} ALTERADO":mysqli_error($conn);
            mysqli_close($conn);
        }
    }
}
else{
    $pessoa = [];
    $pessoa['id'] = '';
    $pessoa['nome'] = '';
    $pessoa['endereco'] = '';
    $pessoa['bairro'] = '';
    $pessoa['telefone'] = '';
    $pessoa['email'] = '';
    $pessoa['id_cidade'] = '';
    $resultado = '';
}
require_once 'lista_combo_cidades.php';
$form = file_get_contents('html/form.html');

$form = str_replace('{id}',$pessoa['id'],$form);
$form = str_replace('{nome}',$pessoa['nome'],$form);
$form = str_replace('{endereco}',$pessoa['endereco'],$form);
$form = str_replace('{bairro}',$pessoa['bairro'],$form);
$form = str_replace('{telefone}',$pessoa['telefone'],$form);
$form = str_replace('{email}',$pessoa['email'],$form);
$form = str_replace('{cidades}',lista_combo_cidades($pessoa['id_cidade']),$form);
$form = str_replace('{resultado}',$resultado,$form);
print $form;
?>