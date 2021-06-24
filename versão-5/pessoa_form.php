<?php
require_once "db/pessoa.php";
if(!empty($_GET['action'])){
    
    try{
        if($_GET['action'] == 'edit' && !empty($_GET['id'])){
            $id = (int)$_GET['id'];
            $pessoa = Pessoa::find($id);
        }
        elseif($_GET['action'] == 'save' && !empty($_POST)){
            $pessoa = $_POST;
            Pessoa::save($pessoa);  
        }
    }
    catch(Exception $e){
        print $e->getMessage();
    }
}
else{
    $pessoa = array('id'=>'','nome'=>'','endereco'=>'','bairro'=>'','telefone'=>'',
    'email'=>'','id_cidade'=>'');
}
$replace = array('{id}','{nome}','{endereco}','{bairro}','{telefone}','{email}','{cidades}');
if(isset($pessoa)){
    $pessoa['id_cidade'] = Pessoa::lista_combo_cidades($pessoa['id_cidade']);
}
$form = file_get_contents('html/form.html');
$form = str_replace($replace,isset($pessoa)?$pessoa:'',$form);
print $form;
?>