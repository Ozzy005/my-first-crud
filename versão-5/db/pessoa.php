<?php
class Pessoa{

    private static $dsn = 'mysql:dbname=livro; host=localhost';
    private static $user = 'root';
    private static $pass = '';

    public static function save($pessoa){

        $conn = new PDO(self::$dsn,self::$user,self::$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if(empty($pessoa['id'])){
            $result = $conn->query("SELECT max(id) as next FROM pessoa");
            $row = $result->fetch();
            $pessoa['id'] = (int)$row['next']+1;

            $sql = "INSERT INTO pessoa (id,nome,endereco,bairro,telefone,email,
            id_cidade) VALUES ('{$pessoa['id']}','{$pessoa['nome']}','{$pessoa['endereco']}',
            '{$pessoa['bairro']}','{$pessoa['telefone']}','{$pessoa['email']}',
            '{$pessoa['id_cidade']}')";
        }
        else{
            $sql = "UPDATE pessoa SET nome = '{$pessoa['nome']}',
            endereco = '{$pessoa['endereco']}', bairro = '{$pessoa['bairro']}',
            telefone = '{$pessoa['telefone']}',email = '{$pessoa['email']}',
            id_cidade = '{$pessoa['id_cidade']}' WHERE id = '{$pessoa['id']}'";
        }
        return $conn->query($sql);
    }

    public static function find($id){
        $conn = new PDO(self::$dsn,self::$user,self::$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $result = $conn->query("SELECT * FROM pessoa WHERE id = '{$id}'");
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function all(){
        
        $conn = new PDO(self::$dsn,self::$user,self::$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $result = $conn->query("SELECT * FROM pessoa ORDER BY id");
        $pessoas1 = $result->fetchAll(PDO::FETCH_ASSOC);
        

        $result = $conn->query("SELECT id,nome FROM cidade");
        $cidades = $result->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($pessoas1) && !empty($cidades)){
            foreach($pessoas1 as $pessoa1){
                foreach($cidades as $cidade){
                    if($pessoa1['id_cidade'] == $cidade['id']){
                        $pessoa1['id_cidade'] = $cidade['nome'];
                        $pessoas[] = $pessoa1;
                    }
                }
            }
        return $pessoas;
        }
    }

    public static function delete($id){
        $conn = new PDO(self::$dsn,self::$user,self::$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $result = $conn->query("DELETE FROM pessoa WHERE id = '{$id}'");
    }

    public static function lista_combo_cidades($id = null){

        $conn = new PDO(self::$dsn,self::$user,self::$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $result = $conn->query('SELECT id,nome FROM cidade');

        $cidades = '';
        if($result){
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $selected = ($row['id'] == $id)?'selected':'';
                $cidades .= "<option value='{$row['id']}' $selected>{$row['nome']}</option>\n"; 
            }
        }
        return $cidades;
    }
}


?>