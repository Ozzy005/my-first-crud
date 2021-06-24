<?php
class Pessoa{

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

    public static function save($pessoa){

        $conn = self::getConnection();

        if(empty($pessoa['id'])){
            $sql = "SELECT max(id) as next FROM pessoa";
            $stm = $conn->prepare($sql);
            $stm->execute();
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $pessoa['id'] = (int)$row['next']+1;

            $sql = "INSERT INTO pessoa (id,nome,endereco,bairro,telefone,email,
            id_cidade) VALUES (:id,:nome,:endereco,:bairro,:telefone,:email,:id_cidade)";
        }
        else{
            $sql = "UPDATE pessoa SET nome = :nome, endereco = :endereco, bairro = :bairro,
            telefone = :telefone, email = :email, id_cidade = :id_cidade WHERE id = :id";
        }
        $stm = $conn->prepare($sql);
        $stm->execute([':id'=>$pessoa['id'],':nome'=>$pessoa['nome'],':endereco'=>$pessoa['endereco'],
        ':bairro'=>$pessoa['bairro'],':telefone'=>$pessoa['telefone'],':email'=>$pessoa['email'],
        ':id_cidade'=>$pessoa['id_cidade']]);
    }

    public static function find($id){

        $conn = self::getConnection();
        $sql = "SELECT * FROM pessoa WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->execute([':id'=>$id]);
        $pessoa =  $stm->fetch(PDO::FETCH_ASSOC);
        return $pessoa;
    }

    public static function all(){
        
        $conn = Pessoa::getConnection();
        $sql = "SELECT * FROM pessoa ORDER BY id";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $pessoas = $stm->fetchAll(PDO::FETCH_ASSOC);
        
        $sql = "SELECT id,nome FROM cidade";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $cidades = $stm->fetchAll(PDO::FETCH_ASSOC);

        $resultado = array();
        if(!empty($pessoas) && !empty($cidades)){
            foreach($pessoas as $pessoa){
                foreach($cidades as $cidade){
                    if($pessoa['id_cidade'] == $cidade['id']){
                        $pessoa['id_cidade'] = $cidade['nome'];
                        $resultado[] = $pessoa;
                    }
                }
            }
        }
        return $resultado;
    }

    public static function delete($id){

        $conn = self::getConnection();
        $sql = "DELETE FROM pessoa WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->execute([':id'=>$id]);
    }

    public static function lista_cidades($pessoa){

        $id = $pessoa['id_cidade'];
        $conn = self::getConnection();
        $sql = "SELECT id,nome FROM cidade";
        $stm = $conn->prepare($sql);
        $stm->execute();

        $cidades = '';
        if($stm){
            while($row = $stm->fetch(PDO::FETCH_ASSOC)){
                $selected = $row['id'] == $id?'selected':'';
                $cidades .= "<option value={$row['id']} $selected>{$row['nome']}</option>"; 
            }
        }
        $pessoa['id_cidade'] = $cidades;
        return $pessoa;
    }
}   
?>