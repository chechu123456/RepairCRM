<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaguineitor3000</title>
</head>
<body>
    <div class="contenedorPrincipal">
        <div class="tit">
            <h1>Buscador Errores plugins / modulos - WordPress / PrestaShop </h1>
        </div>
        <div class="formulario">

            <form action="rp.php" method="post">
                
                <div class="crm">
                    <label for="crmOpcion">Elige la apliación instalada</label>
                    <p><input type="radio" name="crmOpcion" id="crmOpcion" value="wordpress"  checked="checked">Wordpress</p>
                    <p><input type="radio" name="crmOpcion" id="crmOpcion" value="prestashop">Prestashop</p>
                </div>
                <div class="urlSolicitud">
                    <label for="">Introduce la url completa para realizar la solicitud </label>
                    <input type="url" name="url" id="url" size="60" value="https://<?=$_SERVER['SERVER_NAME']?>">
                    <p>Obtener detalles del dominio <a href="https://sered.thechechubark.online/?dm=<?=$_SERVER['SERVER_NAME']?>" target="_blank"><?=$_SERVER['SERVER_NAME']?></a></p>
                </div>
                <hr>
                <h1>Prestashop</h1>
                <div class="prestashop ocultar">
                    <input type="radio" name="modulosPr" id="modulosPr" value="onAll">
                    <label for="modulosPr">Activar todos los módulos de Prestashop</label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="offAll"  checked="checked">
                    <label for="modulosPr">Desactivar todos módulo</label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="offBase">
                    <label for="modulosPr">Desactivar módulos base de Prestashop</label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="offAny">
                    <label for="">Desactivar TODOS los módulos MENOS los base de Prestashop</label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="offErrors">
                    <label for="modulosPr">Desactivar SOLO los módulos que aparecen en el errorlog </label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="nothing">
                    <label for="modulosPr">No hacer cambios</label>
                </div>
                <hr>
                <div class="wordpress ocultar">
                    <h1>WordPress</h1>
                    <p><input type="radio" name="pluginsWp" id="pluginsWp" value="onALLplugins"> <label for="pluginsWp">Activar todos módulos o plugins</label></p>
                    <p><input type="radio" name="pluginsWp" id="pluginsWp" value="offALLplugins" > <label for="pluginsWp" >Desactivar todos plugins </label></p>
                    <p><input type="radio" name="pluginsWp" id="pluginsWp" value="offErrorPlugins" > <label for="pluginsWp">Desactivar SOLO los plugins que aparecen en el errorlog </label></p>
                    <p><input type="radio" name="pluginsWp" id="pluginsWp" value="nothing" checked="checked"> <label for="pluginsWp">No hacer cambios</label></p>
                </div>
                <hr>
                <div class="extra">
                    <h3>Opciones extra</h3>
                    <p><input type="checkbox" name="extra[]" value="emptyFiles" id="extra" checked="checked" >Comprobar ficheros vacíos</p>
                    <p><input type="checkbox" name="extra[]" value="theme" id="extra" checked="checked">Verificar Tema en uso y existencia de ficheros</p>
                    <p><input type="checkbox" name="extra[]" value="cache" id="extra" checked="checked">Borrar cache LiteSpeed por cada plugin activado</p>
                </div>

                <hr>

                <div class="errorLog">
                    <h3>Error_logs:</h3>
                    <p>
                        <input type="checkbox" name="extra[]"  value="mostrarErrorLog" id="mostrarErrorLog" >
                        <label for="mostrarErrorLog">Mostrar error_log hoy</label>
                    </p>
                    <p>
                        <input type="radio" name="extra[]" value="eliminarErrorLog"  id="eliminarErrorLog" >
                        <label for="eliminarErrorLog">Eliminar error_log al finalizar el proceso</label>
                    </p>
                    <p>
                        <input type="radio" name="extra[]" value="renombrarErrorLog" id="renombrarErrorLog">
                        <label for="renombrarErrorLog">Renombrar error_log al finalizar el proceso</label>
                    </p>
                    <p>
                        <input type="radio" name="extra[]" value="nothingErrorLog" id="nothingErrorLog" checked="checked">
                        <label for="noCambiarErrorLog">No hacer nada con el error_log</label>
                    </p>
                </div>
              
                <div class="btnEnviar">
                    <input type="submit" value="Enviar">
                </div>

            </form>
            <br>
            <button>Cambiar tema</button>
        </div>
    </div>
     
</body>
</html>