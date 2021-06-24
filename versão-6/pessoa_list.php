<?php
require_once "db/pessoa.php";

try{
    if(!empty($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['id'])){
        $id = (int)$_GET['id'];
        Pessoa::delete($id);
    }
    $pessoas = Pessoa::all();
}
catch(Exception $e){
    print $e->getMessage();
}
$itens = '';
if(!empty($pessoas)){
    foreach($pessoas as $pessoa){
        $item = file_get_contents('html/item.html');
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