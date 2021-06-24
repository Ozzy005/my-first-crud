<?php
require_once "db/Database.php";

class PessoaList{
    private $html;

    public function __construct(){
        $this->html = file_get_contents('html/list.html');
    }
    
    public function load(){
        try{
            $dados = Database::all();
            $itens = '';
            if(!empty($dados)){
                foreach($dados as $dado){
                $item = file_get_contents('html/item.html');
                $replace = array('{id}','{nome}','{endereco}','{bairro}','{telefone}',
                '{email}','{id_cidade}','{cidade}');

                $item = str_replace($replace,$dado,$item);
                $itens .= $item;
                }
            }
            $this->html = str_replace('{itens}',$itens,$this->html);
        }
        catch(Exception $e){
            print $e->getMessage();
        }
    }
    public function delete($dados){
        try{
            $id = (int)$dados['id'];
            Database::delete($id);
        }
        catch(Exception $e){
            print $e->getMessage();
        }
    }
    public function show(){
        $this->load();
        print $this->html;
    }
}


?>