<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    require_once 'lutador.php';
    require_once 'luta.php';
    $l = array();
    $l[0] = new lutador("Pretty Boy", "França", 31, 1.75, 68.9, 11, 2, 1);
    $l[1] = new lutador("Putscript", "Brasil", 29, 1.68, 57.8, 14, 2, 3 );
    $l[2] = new lutador("SnapShadow", "EUA", 35, 1.65, 80.9, 13, 5, 4 );
    $l[3] = new lutador("Dead Code", "Austrália", 28, 1.93, 81.6, 13, 0, 2 );
    $l[4] = new lutador("UFOCobol", "Brasil", 37, 1.70, 119.3, 5, 4, 3 );
    $l[5] = new lutador("Nerdaart", "EUA", 30, 1.81, 105.7, 12, 2, 4 );
    $uec01 = new luta();
    $uec01->marcarLuta($l[0], $l[1]);
    $uec01->lutar();
    $l[0]->apresentar();
     ?>
</body>
</html>