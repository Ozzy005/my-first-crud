<?php
require_once "db/pessoa_db.php";

if(!empty($_GET['action']) && $_GET['action'] == 'delete'){
    $id = (int)$_GET['id'];
    exclui_pessoa($id);
}

$pessoas = lista_pessoas();
$itens = '';
if($pessoas){
    foreach($pessoas as $pessoa){
        $item = file_get_contents('html/item.html');
        $pessoa['id_cidade'] = lista_cidade($pessoa['id_cidade']);
        $replace = array('{id}','{nome}','{endereco}','{bairro}','{telefone}',
        '{email}','{cidade}');

        $item = str_replace($replace,$pessoa,$item);
        $itens .= $item;
    }
}
$list = file_get_contents('html/list.html');
$list = str_replace('{itens}',$itens,$list);
print $list;
?>