<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de pessoa</title>
        <link href="css/form.css" rel="stylesheet" type="text/css" media="screen"/>
    </head>
    <body>
        <form enctype="multipart/form-data" method="post" action="pessoa_save_insert.php">
            
            <label>Código</label>
            <input name="id" readonly="1" type="text" style="width: 30%">

            <label>Nome</label>
            <input name="nome" type="text" style="width: 50%">

            <label>Endereço</label>
            <input name="endereco" type="text" style="width: 50%">

            <label>Bairro</label>
            <input name="bairro" type="text" style="width: 25%">

            <label>Telefone</label>
            <input name="telefone" type="text" style="width: 25%">

            <label>Email</label>
            <input name="email" type="text" style="width: 25%">

            <label>Cidade</label>
            <select name="id_cidade" style="width: 25%">
                <?php
                    require_once 'lista_combo_cidades.php';
                    print lista_combo_cidades();
                ?>
            </select>

            <input type="submit" value="Cadastrar">
            <a href="pessoa_list.php"><button type="button">Listar</button></a>

        </form>
    </body>
</html>