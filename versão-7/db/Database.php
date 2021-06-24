<?php
class Database{

    private static $conn;

    public static function getConnection(){
        if(empty(self::$conn)){
            $conexao = parse_ini_file('config/livro.ini');
            $dsn = "mysql:dbname={$conexao['dbname']};host={$conexao['host']}";
            $user = $conexao['user'];
            $pass = $conexao['pass'];
            self::$conn = new PDO($dsn,$user,$pass);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

    public static function save($dados){
        
        if(isset($dados['id']) && isset($dados['nome']) && isset($dados['endereco']) && isset($dados['bairro'])
        && isset($dados['telefone']) && isset($dados['email']) && isset($dados['id_cidade'])){

            $dados = ['modo'=>'NOVO CADASTRO','id'=>$dados['id'],'nome'=>$dados['nome'],
            'endereco'=>$dados['endereco'],'bairro'=>$dados['bairro'],'telefone'=>$dados['telefone'],
            'email'=>$dados['email'],'id_cidade'=>$dados['id_cidade'],'cidades'=>'','registro'=>''];
        }
        else{
            $dados = ['modo'=>'NOVO CADASTRO','id'=>'','nome'=>'','endereco'=>'','bairro'=>'',
            'telefone'=>'','email'=>'','id_cidade'=>'','cidades'=>'','registro'=>''];
        }

        

        if(!empty($dados['nome']) && !empty($dados['endereco']) && !empty($dados['bairro']) && 
        !empty($dados['telefone']) && !empty($dados['email'])){

            $dados['modo'] = 'ALTERAR CADASTRO';

            $conn = self::getConnection();

            if(empty($dados['id'])){
                $sql = "SELECT max(id) as next FROM pessoa";
                $stm = $conn->prepare($sql);
                $stm->execute();
                $row = $stm->fetch(PDO::FETCH_ASSOC);
                $dados['id'] = (int)$row['next']+1;

                $sql = "INSERT INTO pessoa (id,nome,endereco,bairro,telefone,email,
                id_cidade) VALUES (:id,:nome,:endereco,:bairro,:telefone,:email,:id_cidade)";

                $dados['registro'] = "<span class='registro-salvo L'>Novo registro Nº{$dados['id']}</span>";
                
            }
            else{
                $sql = "UPDATE pessoa SET nome = :nome, endereco = :endereco, bairro = :bairro,
                telefone = :telefone, email = :email, id_cidade = :id_cidade WHERE id = :id";

                $dados['registro'] = "<span class='registro-salvo L'>Registro Nº{$dados['id']} alterado</span>";
                
            }
            $stm = $conn->prepare($sql);
            $stm->execute([':id'=>$dados['id'],':nome'=>$dados['nome'],':endereco'=>$dados['endereco'],
            ':bairro'=>$dados['bairro'],':telefone'=>$dados['telefone'],':email'=>$dados['email'],
            ':id_cidade'=>$dados['id_cidade']]);
        }
        else{
            $dados['registro'] = "<span class='registro-falhou L'>Registro falhou ! Dados insuficientes !</span>";
        }
        return $dados;
    }

    public static function find($id){

        $conn = self::getConnection();
        $sql = "SELECT * FROM pessoa WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->execute([':id'=>$id]);

        $dados =  $stm->fetch(PDO::FETCH_ASSOC);
        $dados = array_merge(['modo' => 'ALTERAR CADASTRO'], $dados);
        return $dados;
    }

    public static function all(){
        
        $conn = self::getConnection();
        $sql = "SELECT * FROM pessoa ORDER BY id";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $pessoas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $sql = "SELECT id,nome FROM cidade";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $cidades = $stm->fetchAll(PDO::FETCH_ASSOC);

        $dados = array();
        if(!empty($pessoas) && !empty($cidades)){
            foreach($pessoas as $pessoa){
                foreach($cidades as $cidade){
                    if($pessoa['id_cidade'] == $cidade['id']){

                        $pessoa['cidade'] = $cidade['nome'];
                        $dados[] = $pessoa;
                    }
                }
            }
        }
        return $dados;
    }

    public static function delete($id){

        $conn = self::getConnection();
        $sql = "DELETE FROM pessoa WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->execute([':id'=>$id]);
    }

    public static function add_cidades($id_cidade){

        $conn = self::getConnection();
        $sql = "SELECT id,nome FROM cidade";
        $stm = $conn->prepare($sql);
        $stm->execute();

        $cidades = '';
        if(!empty($stm)){
            while($row = $stm->fetch(PDO::FETCH_ASSOC)){
                $selected = $row['id'] == $id_cidade?'selected':'';
                $cidades .= "<option value={$row['id']} $selected>{$row['nome']}</option>";
            }
        }
        return $cidades;
    }
}   
?>