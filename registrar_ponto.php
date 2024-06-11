<?php 

    session_start();
    ob_start(); //Limpar o buffer

    // Definir um fuso horário paDrão
    date_default_timezone_set("America/Sao_Paulo");


    // Gerar com PHP o horário atual
    $horario_atual = date("H:i:s");
    #var_dump($horario_atual);

    // Gerar a data com PHP no formato que deve ser salvo no bd
    // Essa data será salva na coluna data_entrada
    $data_entrada = date('Y/m/d');

    // Conexao com banco de dados
    include_once "conexao.php";

    // ID Do usuario logaDo (FIXO MUDAR DEPOIS)
    $id_usuario = 1;

    // Recuperar ultimo ponto do usuário
    $query_ponto = "SELECT id AS id_ponto, saida_intervalo, retorno_intervalo, saida
            FROM pontos 
            WHERE usuario_id = :usuario_id
            ORDER BY id DESC
            LIMIT 1";
    

    //preparando a query
    $result_ponto = $conn->prepare($query_ponto);
    $result_ponto->bindValue(":usuario_id", $id_usuario);
    $result_ponto->execute();

    if(($result_ponto) and ($result_ponto->rowCount() > 0)) {

        // Verificando se encontrou algo no banco
        $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);
        
        #var_dump($row_ponto);

        // Extrair para imprimir atraves do nome da chave no array
        //atraves disso está sendo usado a variável $saida_intervalo e as demais atraves do extract
        extract($row_ponto);


        // Verificar se o usuario bateu o ponto saida para o intervalo
        if(($saida_intervalo == "") OR ($saida_intervalo == NULL)) {
            
            // coluna que deve receber  o valor
            $col_tipo_registro = "saida_intervalo";

            // Tipo de registro
            $tipo_registro = "editar";

            // Texto parcial a ser mostrado ao usuário
            $text_tipo_registro = "saida intervalo";

        }elseif(($retorno_intervalo == "") OR ($retorno_intervalo == NULL)) {

            //Verificano se usuario bateu retorno intervalo

            // coluna que deve receber  o valor
            $col_tipo_registro = "retorno_intervalo";

            // Tipo de registro
            $tipo_registro = "editar";

            // Texto parcial a ser mostrado ao usuário
            $text_tipo_registro = "retorno intervalo";

        }elseif(($saida == "") OR ($saida == NULL)) {

            //Verificano se usuario bateu de saida

            // coluna que deve receber  o valor
            $col_tipo_registro = "saida";

            // Tipo de registro
            $tipo_registro = "editar";

            // Texto parcial a ser mostrado ao usuário
            $text_tipo_registro = "saida";

        }else {
            //Criar um novo registro com horario de entrada

            // Tipo de registro
            $tipo_registro = "entrada";

            // Texto parcial a ser mostrado ao usuário
            $text_tipo_registro = "entrada";
        }

    } else {
         // Tipo de registro
         $tipo_registro = "entrada";

         // Texto parcial a ser mostrado ao usuário
         $text_tipo_registro = "entrada";
    }

    // Verificar o tipo e registro, novo ponto ou editar registro existente
    switch($tipo_registro) {
        case "editar":
            $query_horario = "UPDATE pontos SET $col_tipo_registro = :horario_atual
                WHERE id = :id
                LIMIT 1";

            $cad_horario = $conn->prepare($query_horario);
            $cad_horario->bindValue(':horario_atual', $horario_atual);
            $cad_horario->bindValue(':id', $id_ponto);
        break;
        
        default:
            //Cadastrar no banco de dados
            $query_horario = "INSERT INTO pontos (data_entrada, entrada, usuario_id) VALUES (:data_entrada, :entrada, :usuario_id )";
            
            $cad_horario = $conn->prepare($query_horario);
            $cad_horario->bindValue(':data_entrada', $data_entrada);
            $cad_horario->bindValue(':entrada', $horario_atual);
            $cad_horario->bindValue(':usuario_id', $id_usuario);
        break;


    }

    //Executando a query
    $cad_horario->execute();

    if($cad_horario->rowCount()) {
        $_SESSION['msg'] = "<p style='color:green'>Horario de $text_tipo_registro cadastrado com sucesso</p>";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['msg'] =  "<p style='color:#f00'>Horario de $text_tipo_registro falhou cadastrar</p>";
        header("Location: index.php");
        exit;
    }
?>