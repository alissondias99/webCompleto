<?php
    $dsn = 'mysql:host=localhost; dbname=php_com_pdo';
    $user = 'root';
    $senha = '' ;
/*
    try{
    $conexao = new PDO($dsn, $user, $senha);
    
    $query = '
            create table if not exists tb_users(
                id int not null primary key auto_increment,
                nome varchar(50) not null,
                email varchar(100) not null,
                senha varchar(32) not null
            )
    ';

    $query = '
            insert into tb_users(nome, email, senha) values
            ("Alisson", "teste@gmail.com", "123456")
    ';

    $query = '
            insert into tb_users(nome, email, senha) values
            ("Jonny", "jonnnyy@gmail.com", "789101")
    ';
    $conexao->exec($query);

    $query = '
            insert into tb_users(nome, email, senha) values
            ("Lenna", "lena@gmail.com", "AbcD")
    ';
    $conexao->exec($query);
    

    
    $query = '
        select * from tb_users
    ';
    $stmt = $conexao->query($query);
    $lista = $stmt->fetchAll(); // comando usado para retornar todos registros de um consulta em formato de um array;
    //              fetchAll(PDO::FETCH_ASSOC) -retorna só itens associativos    
    //              fetchAll(PDO::FETCH_NUM) - retorna só itens numéricos
    //              fetchAll(PDO::FETCH_BOTH) - retorna ambos
    //              https://www.php.net/manual/en/pdostatement.fetchall.php - outras funções

    echo '<pre>';
    print_r($lista);
    echo '</pre>';

    echo $lista[0]['nome']; // pode ser manipulado da mesma maneira de um array também

    } catch (PDOException $e){
        echo 'Erro '. $e->getCode(). ' Mensagem ' . $e->getMessage(); 
        //https://www.php.net/manual/pt_BR/class.pdoexception.php
    }
?>*/

if(!empty($_POST['usuario']) && !empty($_POST['senha'])) {

    $dsn = 'mysql:host=localhost;dbname=php_com_pdo';
    $usuario = 'root';
    $senha = '';

    try {
        $conexao = new PDO($dsn, $usuario, $senha);

        $query = "select * from tb_users where ";
        $query .= " email = :usuario ";
        $query .= " AND senha = :senha ";

        $stmt = $conexao->prepare($query); //ele não executa diretamente a query, ele aguarda seu ok para executar
        
        $stmt->bindValue(':usuario', $_POST['usuario']);
        $stmt->bindValue(':senha', $_POST['senha']);

        $stmt->execute(); //executa a query depois do bindValue

        $usuario = $stmt->fetch();

        print_r($usuario);

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getCode() . ' Mensagem: ' . $e->getMessage();
        //registrar o erro de alguma forma.
    }

}
?>

<html>
    <meta charset="utf-8">
    <title>Login</title>
</html>
<body>
    <form method="post" action="index.php">
        <input type="text" placeholder="usuário" name="usuario"/>
        <br/>
        <input type="password" placeholder="senha" name="senha"/>
        <br/>
        <button type="submit">Entrar</button>
    </form>
</body>
