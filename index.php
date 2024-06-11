<?php 
    // Definir um fuso horário paDrão
    date_default_timezone_set("America/Sao_Paulo");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Ponto</title>
</head>
<body>
    <h2>Registro de Ponto</h2>
    <p id="horario"><?= date("d/m/Y H:i:s");?></p>
    <a href="registrar_ponto.php">Registrar</a>


    <script>
        var apHorario = document.getElementById("horario");

        function atualizarHorario() {
            // console.log('atualizarHorario')
            var data = new Date().toLocaleString("pt-br", {
                timeZone: "America/Sao_Paulo"
            });
            
           document.getElementById("horario").innerHTML = data.replace(", " , " - ");
        }

        setInterval(atualizarHorario, 1000);
    </script>
</body>
</html>