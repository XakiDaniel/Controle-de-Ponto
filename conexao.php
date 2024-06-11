<?php 

    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "xdb";
    $port = 3306;

    try {
        //Conexao com a porta
        # $conn = new PDO("mysql:host=$host;port=$port;dbname=$db_name, $db_user, $db_pass");

        //Conexao sem a porta
        $conn = new PDO("mysql:host=$db_host;dbname=". $db_name, $db_user, $db_pass);
        #echo "Conexao feita";
    } catch (PDOException $e) {
        echo "Falha" . $e->getMessage();
    }

?>