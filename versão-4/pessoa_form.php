<?php
require_once "db/pessoa_db.php";
if(!empty($_REQUEST['action'])){
    
    if($_REQUEST['action'] == 'edit'){
        $id = (int)$_GET['id'];
        $pessoa = get_pessoa($id);
    }
    elseif($_REQUEST['action'] == 'save'){
        $pessoa = $_POST;
    
        if(empty($pessoa['id'])){
            $pessoa['id'] = get_next_pessoa();
            $pessoa['result'] = insert_pessoa($pessoa);
        }
        else{
            $pessoa['result'] = update_pessoa($pessoa);
        }
    }
}
else{
    $pessoa = array('id'=>'','nome'=>'','endereco'=>'','bairro'=>'','telefone'=>'',
    'email'=>'','id_cidade'=>'','result'=>'');
}
$replace = array('{id}','{nome}','{endereco}','{bairro}','{telefone}','{email}','{cidades}','{result}');
$pessoa['id_cidade'] = lista_combo_cidades($pessoa['id_cidade']);
$form = file_get_contents('html/form.html');
$form = str_replace($replace,$pessoa,$form);
print $form;
?>