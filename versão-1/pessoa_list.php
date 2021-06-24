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
        $sql = "SELECT * FROM pessoa ORDER BY id";
        $result = mysqli_query($conn,$sql);

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
            $id_cidade = $row['id_cidade'];

            print "<tr>"; //abre linha
            print "<td align='center'>
                   <a href='pessoa_form_edit.php?id={$id}'>
                   <img src='img/editar-arquivo.png' style='width:17px'>
                   </a></td>";

            print "<td align='center'>
                   <a href='pessoa_delete.php?id={$id}'>
                   <img src='img/apagar.png' style='width:17px'>
                   </a></td>";

            print "<td>{$id}</td>";
            print "<td>{$nome}</td>";
            print "<td>{$endereco}</td>";
            print "<td>{$bairro}</td>";
            print "<td>{$telefone}</td>";
            print '</tr>'; //fecha linha
        }
        print "</tbody>";//fecha corpo
        print "</table>";//fecha tabela
        ?>

        <button onclick="window.location='pessoa_form_insert.php'">
        <img src='img/inserir.png' style='width:17px'>
        Inserir
        </button>
        

    </body>
</html>