<?php
require_once 'datos.php';
session_start();
session_unset();
session_destroy();
require_once 'header.php';
 ?>
        </header>
            <main>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Ingresar</h3>
                </div>
                <div class="panel-body">
                    <form class="" role="form" action="core/authentication.php" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class=form-control placeholder="E-mail" type="text" name="user" id="user" value="" onblur="check_user(this, true)">
                                <div class="">

                                </div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="clave" type="password" name="pwd" id="pwd" value="">

                            </div>
                            <!--<div class="checkbox">
                                <label for="">
                                    <input type="checkbox" name="remember" value="remember">Recordarme
                                </label>
                            </div>-->
                            <button type="submit" name="button" class="btn btn-lg btn-success btn-block">Enviar</button>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-6">
                        <a href="signup.php">Registrarse</a>
                    </div>
                    <div class="col-md-6">
                        <!--<a href="#">Recuperar Clave</a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-danger">
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">Ingrese en modo de demostración</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <button class="btn btn-warning btn-block" type="button" name="button" onclick="demoAdmin()">Administrador</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block" type="button" name="button" onclick="demoUser()">Usuario</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-info">
                <div class="panel-body">
                    <a data-target="#myModal" class="btn btn-lg btn-primary" data-toggle="modal">Ver Video de Muestra</a>
                </div>
            </div>
        </div>
    </div>
    <div class="bs-example">

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">YouTube Video</h4>
                </div>
                <div class="modal-body">
                    <iframe id="cartoonVideo" width="560" height="315" src="static/prueba2.mp4" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?php echo PROJECT_HOST; ?>js/forms.js" charset="utf-8"></script>
<script src="<?php echo PROJECT_HOST; ?>js/ajax.js" charset="utf-8"></script>
<script type="text/javascript">
    window.onload = function(){

    }
    function demoAdmin(){
        setTimeout(function(){
            //window.locate.href = "resetdb.php";
            alert('reset');
        }, (5*60*1000));
        window.location.href = "demo.php?arg=1";
    }
    function demoUser(){
        setTimeout(function(){
            //window.locate.href = "resetdb.php";
            alert('reset');
        }, (5*60*1000));
        window.location.href = "demo.php?arg=2";
    }
</script>
<script src="<?php echo PROJECT_HOST.TEMPLATE;?>vendor/bootstrap/js/bootstrap.min.js"></script>
            </main>
        </div>
    </body>
</html>
