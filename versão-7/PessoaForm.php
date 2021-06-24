<?php
require_once "db/Database.php";
class PessoaForm{
    private $html;
    private $dados;

    public function __construct(){
        $this->html = file_get_contents('html/form.html');
        $this->dados = array('modo'=>'NOVO CADASTRO','id'=>'','nome'=>'','endereco'=>'','bairro'=>'',
        'telefone'=>'','email'=>'','id_cidade'=>'','cidades'=>'','registro'=>'');
    }
    public function edit($dados){
        try{
            $id = (int)$dados['id'];
            $pessoa = Database::find($id);
            $this->dados = $pessoa;
        }
        catch(Exception $e){
            print $e->getMessage();
        }
    }
    public function save($dados){
        try{
            $dados = Database::save($dados);
            $this->dados = $dados;
            
        }
        catch(Exception $e){
            print $e->getMessage();
        }
    }
    public function show(){
        $this->dados['cidades'] = Database::add_cidades($this->dados['id_cidade']);
        $replace = array('{modo}','{id}','{nome}','{endereco}','{bairro}','{telefone}','{email}','{id_cidade}','{cidades}','{registro}');
        $this->html = str_replace($replace,$this->dados,$this->html);
        print $this->html;
    }
}
?>