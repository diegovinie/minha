<?php
// Controlador: js/profile.js
// Modelo: authentication.php

session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'server.php';
$con = connect();

$q = "SELECT bui_id, bui_name, bui_apt FROM buildings WHERE bui_id = " .$_SESSION['apt'];
$r = q_exec($q);
$bui = query_to_assoc($r)[0];

 ?>

<div id='page-wrapper'>
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Perfil</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="" action="../core/async_profile.php" method="post">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-8">
                                <label for="building">Edificio:</label>
                                <input type="text" id="building" name="building" class="form-control" value=<?php echo $bui['bui_name']; ?> readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="apt">Apartamento:</label>
                                <input type="text" id="apt" name="apt" class="form-control" value=<?php echo $bui['bui_apt']; ?> readonly>
                            </div>
                            <input type="text" name="bui_id" id="bui_id" value=<?php echo $bui['bui_id']; ?> hidden>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="condition">Condición:</label>
                            </div>

                            <div class="col-md-6" id="cond">

                                <input id="titular" type="radio" name="cond" value="" disabled>
                                <label for="tit">Titular</label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" name="cond" value="" id="familiar" disabled>
                                <label for="cond">Familiar
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name">Nombres:</label>
                            <input type="text" class="form-control" id="name" name="name"  readonly>
                            <a onclick="edit(this);">Editar</a>
                        </div>
                        <div class="form-group">
                            <label for="surname">Apellidos:</label>
                            <input type="text" id="surname" name="surname" class="form-control"  readonly>
                            <a onclick="edit(this);">Editar</a>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6" >
                                <label for="ci">Cédula de Identidad:</label>
                                <input type="text" id="ci" name="ci" class="form-control"  readonly>
                                <a onclick="edit(this);">Editar</a>
                            </div>
                            <div class="col-md-6">
                                <label for="nac">Fecha Nacimiento:</label>
                                <input type="date" name="nac" class="form-control"  readonly>
                                <a onclick="edit(this);">Editar</a>
                            </div>
                            <div class="col-md-12">

                            </div>
                        </div>
                        <div class="from-group">
                            <div class="col-md-6">
                                <label for="cel">Número Celular:</label>
                                <input type="text" id="cel" name="cel" class="form-control"  readonly>
                                <a data-target="#cambioCel" data-toggle="modal">Editar</a>
                            </div>

                            <div class="col-md-6">
                                <label for="gen">Género:</label>
                                <input type="text" class="form-control" name="gen" id="gen"  readonly>
                                <a onclick="edit(this);">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Datos de Acceso:
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="text" id="email" name="email" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <a data-target="#cambioPregunta" data-toggle="modal" onclick="getQuestion()">Pregunta de Seguridad</a>

                        </div>
                        <div class="form-group">
                            <a onclick="pwdDialog()">Cambio de Clave</a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Datos de la Vivienda
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="checkbox">
                                <label for="multi"><input type="checkbox" id="multi" name="multi" value="1"> Documento Multifamiliar</label>
                            </div>
                            <div class="checkbox">
                                <label for=""><input type="checkbox" name="uni" value="1"> Documento Unifamiliar</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Servicio de gas:</label>
                            <div class="">
                                <label  class="radio-inline"><input type="radio" id="opgas" name="gas" value="1">Operativo</label>
                                <label  class="radio-inline"><input type="radio" name="gas" id="degas" value="2">Defectuoso</label>
                                <label  class="radio-inline"><input type="radio" name="gas" id="nogas" value="3">No instalado</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Telefonía fija CANTV:</label>
                            <div class="">
                                <label  class="radio-inline"><input type="radio" name="telcantv" id="optelcantv" value="1">Operativo</label>
                                <label  class="radio-inline"><input type="radio" name="telcantv" id="detelcantv" value="2">Defectuoso</label>
                                <label  class="radio-inline"><input type="radio" name="telcantv" id="notelcantv" value="3">No instalado</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Internet CANTV ABA:</label>
                            <div class="">
                                <label  class="radio-inline"><input type="radio" name="abacantv" id="opabacantv" value="1">Operativo</label>
                                <label  class="radio-inline"><input type="radio" name="abacantv" id="deabacantv" value="2">Defectuoso</label>
                                <label  class="radio-inline"><input type="radio" name="abacantv" id="noabacantv" value="3">No instalado</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>TV Satelital CANTV:</label>
                            <div class="">
                                <label  class="radio-inline"><input type="radio" name="tvcantv" id="optvcantv" value="1">Operativo</label>
                                <label  class="radio-inline"><input type="radio" name="tvcantv" id="detvcantv" value="2">Defectuoso</label>
                                <label  class="radio-inline"><input type="radio" name="tvcantv" id="notvcantv" value="3">No instalado</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>DirecTV:</label>
                            <div class="">
                                <label  class="radio-inline"><input type="radio" name="directv" id="opdirectv" value="1">Operativo</label>
                                <label  class="radio-inline"><input type="radio" name="directv" id="dedirectv" value="2">Defectuoso</label>
                                <label  class="radio-inline"><input type="radio" name="directv" id="nodirectv" value="3">No instalado</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="">Número de automóviles
                                </label>
                                <input type="number" class="form-control" name="cars" id="cars">
                                <!--<select class="form-control" name="">
                                    <option value="0" selected>0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>-->


                            </div>
                            <div class="col-md-6">
                                <label for="a" class="form-inline">Número de motos</label>
                                <input type="number" class="form-control" name="motos" id="motos">
                                <!--<select class="form-control" name="">
                                    <option value="0" selected>0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>-->
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <button type="submit" class="btn btn-info btn-block" name="submit">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="cambioCel" role="dialog">
        <div class="modal-dialog modal-sm panel panel-info">
            <div class="modal-header">
                <label>Número Celular:</label>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-5">
                        <select class="form-control" name="prefix">
                            <option value="0412">0412</option>
                            <option value="0414">0414</option>
                            <option value="0424">0424</option>
                            <option value="0416">0416</option>
                            <option value="0426">0426</option>

                        </select>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="number" class="form-control">
                    </div>
                </div>
                <div align="center"></div>
                <div class="form-group" align="center">
                    <a class="btn btn-info" onclick="changeCel(this)">Aplicar</a>
                    <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="cambioPregunta" role="dialog">
        <div class="modal-dialog panel panel-info">
            <div class="modal-header">
                Cambio de pregunta secreta
            </div>
            <form class="modal-body">
                <div class="form-group">
                    <label for="">Pregunta:</label>
                    <input type="text" class="form-control" name="question" id="question">
                </div>
                <div class="form-group">
                    <label for="">Respuesta:</label>
                    <input type="text" name="answer" id="answer" class="form-control">
                </div>
                <div align="center"></div>
                <div class="form-group" align="center">
                    <a class="btn btn-success" onclick="changeQuestion(this)">Aplicar</a>
                    <button type="reset" class="btn btn-warning" name="button">Deshacer</button>
                    <button type="back" data-dismiss="modal" class="btn btn-danger" name="button">Regresar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="text" name="user" id="user" value="<?php echo $_SESSION['user_id']; ?>" hidden>

<script src="<?php echo PROJECT_HOST; ?>js/profile.js" charset="utf-8"></script>
<?php
require '../footer.php';
if(isset($time_ini)) rec_exec_time($time_ini, __FILE__, __LINE__);
 ?>
