<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle</title>
</head>
<body>
    <pre>
    <?php
            #ENCAPSULAMENTO
    require_once 'controle.php';
    $c = new controle();
    $c -> ligar();
    $c -> abrirMenu();
    ?>
    </pre>
</body>
</html>