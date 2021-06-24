<html>
    <head>
        <meta charset="UTF-8">
        <title>Listagem de pessoas</title>
        <link href="css/list.css" rel="stylesheet" type="text/css" media="screen"/>
    </head>
    <body>
        <?php
        $localhost = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'livro';
        $conn = mysqli_connect($localhost,$username,$password,$dbname);

        if(!empty($_GET['action']) && $_GET['action'] == 'delete'){
            $id = (int)$_GET['id'];
            $sql_delete = "DELETE FROM pessoa WHERE id = '{$id}'";
            mysqli_query($conn,$sql_delete);
        }


        $sql_select = "SELECT * FROM pessoa ORDER BY id";
        $result = mysqli_query($conn,$sql_select);

        print "<table border=1>"; // abre tabela
        print "<thead>"; //abre cabeça  
        print "<tr>";
        print "<th></th>";
        print "<th></th>";
        print "<th> Id </th>";
        print "<th> Nome </th>";
        print "<th> Endereço </th>";
        print "<th> Bairro </th>";
        print "<th> Telefone </th>";
        print "<th> Email </th>";
        print "</tr";
        print "</thead>"; // fecha cabeça

        print "<tbody>";//abre corpo
        while ($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $nome = $row['nome'];
            $endereco = $row['endereco'];
            $bairro = $row['bairro'];
            $telefone = $row['telefone'];
            $email = $row['email'];

            print "<tr>"; //abre linha
            print "<td align='center'>
                   <a href='pessoa_form.php?action=edit&id={$id}'>
                   <img src='img/editar-arquivo.png' style='width:17px'>
                   </a></td>";

            print "<td align='center'>
                   <a href='pessoa_list.php?action=delete&id={$id}'>
                   <img src='img/apagar.png' style='width:17px'>
                   </a></td>";

            print "<td>{$id}</td>";
            print "<td>{$nome}</td>";
            print "<td>{$endereco}</td>";
            print "<td>{$bairro}</td>";
            print "<td>{$telefone}</td>";
            print "<td>{$email}</td>";
            print '</tr>'; //fecha linha
        }
        print "</tbody>";//fecha corpo
        print "</table>";//fecha tabela

        mysqli_close($conn);
        ?>

        <button onclick="window.location='pessoa_form.php'">
        <img src='img/inserir.png' style='width:17px'>Inserir</button>
    </body>
</html>