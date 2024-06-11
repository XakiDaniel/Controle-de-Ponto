<?php 
    // Definir um fuso horário paDrão
    date_default_timezone_set("America/Sao_Paulo");


    // Gerar com PHP o horário atual
    $horario_atual = date("H:i:s");
    var_dump($horario_atual);

    // Gerar a data com PHP no formato que deve ser salvo no bd
    $data_entrada = date('Y/m/d');

    // Conexao com banco de dados
?>