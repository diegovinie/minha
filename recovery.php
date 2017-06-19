<?php
//Formulario con verificación de campos JS
require 'datos.php';
require 'header.php';
 ?>

</header>
<main>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
             <h2 class="page-header">Recuperar clave</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">

             <div class="panel panel-default">
                 <div class="panel-heading">
                     <h3 class="panel-title">Conteste la pregunta de seguridad</h3>
                 </div>

                 <div class="panel-body">
                     <div class="form-group">
                         <input class="form-control" type="email" name="email" id="email" placeholder="correo@electron.ico" onblur="checkEmail(this)">
                         <div align="center"></div>
                     </div>
                    <div class="form-group">
                        <label for="">Pregunta:</label>
                        <input class="form-control" type="text" name="question" id="question" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Respuesta:</label>
                        <input type="text" name="response" class="form-control" id="response">
                    </div>
                    <div align="center"></div>
                    <div class="form-group" align="center">
                        <button class="btn btn-success" onclick="checkResponse(this)">Aplicar</button>
                        <a type="back" href="login.php" class="btn btn-danger" name="button">Regresar</a>
                    </div>

                 </div>
             </div>
        </div>
    </div>
     <div class="modal" id="newPwd" role="dialog">
         <div class="modal-dialog modal-sm panel panel-info">
             <div class="modal-header">
                 Escriba una nueva clave:
             </div>
             <div class="modal-body">
                 <div class="form-group">
                     <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Nueva clave" oninput="newPwd(this)" onblur="check_pwd(this)">
                     <div align="center"></div>
                 </div>
                 <div class="form-group">
                     <input type="password" name="pwd_ret" class="form-control" placeholder="Repita la clave" id="pwd_ret" oninput="checkPwdChange(this)" onblur="check_pwd(this)">
                     <div align="center"></div>
                 </div>
                 <div class="form-group" align="center">
                    <a id="pwdSubmit" type="submit" class="btn btn-success" onclick="changePwd()" disabled>Aplicar</a>
                     <a type="back" href="recovery.php" class="btn btn-danger" name="button">Regresar</a>
                 </div>
             </div>
         </div>
     </div>
     <div class="modal" id="alert" role="dialog">
         <div class="modal-dialog modal-sm panel panel-success">
             <div class="modal-body panel-body">
                 <div id="alert_content" class="alert" align="center">
                     Muy Bien!
                 </div>
                 <div align="center">
                     <button type="button" id="alert_btn" name="button" class="btn btn-default" href='login.php'>Regresar</button>
                 </div>
             </div>
         </div>
     </div>
</div>

        </main>
        <script src="<?php echo PROJECT_HOST; ?>js/forms.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST; ?>js/ajax.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST.TEMPLATE;?>vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo PROJECT_HOST;?>js/modal.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST;?>js/recovery.js" charset="utf-8"></script>
    </body>
</html>
