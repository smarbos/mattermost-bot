<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Test</title>
        <link rel="stylesheet" href="estilos.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>
        <?php if($_GET['status'] == 'ok'){ echo "<span class=\"status-ok\">OK</span>"; } ?>
        <?php if($_GET['status'] == 'fail'){ echo "<span class=\"status-fail\">FAIL</span>"; } ?>
        <form class="" action="post.php" method="post">
            <label for="text">Digite el mensaje:</label>
            <textarea rows="5" autocorrect="off" autocapitalize="off" name="text" value="" placeholder="Escriba aqui el mensaje"></textarea>
            <label for="pswd">Digite la clave:</label>
            <input type="password" name="pswd" value="" autocorrect="off" autocapitalize="off" placeholder="Memes">
            <input type="submit" name="enviar" value="Enviar">
        </form>
    </body>
</html>
