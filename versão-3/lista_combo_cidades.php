<?php
function lista_combo_cidades($id = null){

    $output = '';
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'livro';
    $conn = mysqli_connect($host,$username,$password,$dbname);
    $sql = 'SELECT id,nome FROM cidade';

    $result = mysqli_query($conn,$sql);

    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $check = ($row['id'] == $id)?'selected':'';
            $output .= "<option value='{$row['id']}' $check>
            {$row['nome']}</option>\n";
        }
    }
    mysqli_close($conn);
    return $output;
}

?>