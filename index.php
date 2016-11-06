<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Test</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="estilos.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>
        <div class="row">
            <div class="col-sm-12">
                <?php if($_GET['status'] == 'ok'){ echo "<span class=\"status status-ok\">OK</span>"; } ?>
                <?php if($_GET['status'] == 'fail'){ echo "<span class=\"status status-fail\">FAIL</span>"; } ?>
                <form class="" action="post.php" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="text">Digite el mensaje:</label>
                            <textarea autofocus class="inputs" rows="3" autocorrect="off" autocapitalize="off" name="text" value="" placeholder="Escriba aqui el mensaje"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="pswd">Digite la clave:</label>
                            <input class="inputs" type="password" name="pswd" value="" autocorrect="off" autocapitalize="off" placeholder="Memes">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="submit" name="enviar" value="Enviar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<script type="text/javascript">
$('.inputs').keyup(function (e) {
     if (e.which === 13) {
         var index = $('.inputs').index(this) + 1;
         $('.inputs').eq(index).focus();
     }
 });

 $( document ).ready(function() {
     $( ".status" ).fadeOut( 6000, function() {
       // Animation complete
     });
 });

</script>
