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
                    <label for="modulosPr">Desactivar todos módulos o plugins</label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="offBase">
                    <label for="modulosPr">Desactivar módulos base de Prestashop</label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="offAny">
                    <label for="">Desactivar TODOS los módulos MENOS los base de Prestashop</label>
                    <input type="radio" name="modulosPr" id="modulosPr" value="offErrors">
                    <label for="">Desactivar SOLO los módulos o plugins que aparecen en el errorlog </label>
                </div>
                <hr>
                <div class="wordpress ocultar">
                    <h1>WordPress</h1>
                    <p><input type="radio" name="pluginsWp" id="pluginsWp" value="onALLplugins"> <label for="pluginsWp">Activar todos módulos o plugins</label></p>
                    <p><input type="radio" name="pluginsWp" id="pluginsWp" value="offALLplugins"  checked="checked"> <label for="pluginsWp" >Desactivar todos módulos o plugins </label></p>
                    <p><input type="radio" name="pluginsWp" id="pluginsWp" value="offErrorPlugins"> <label for="pluginsWp">Desactivar SOLO los módulos o plugins que aparecen en el errorlog </label></p>
                </div>
                <hr>
                <div class="extra">
                    <label for="extra">Opciones extra</label>
                    <p><input type="checkbox" name="extra[]" value="emptyFiles" id="extra" checked="checked" >Comprobar ficheros vacíos</p>
                    <p><input type="checkbox" name="extra[]" value="theme" id="extra" checked="checked">Verificar Tema en uso y existencia de ficheros</p>
                    <p><input type="checkbox" name="extra[]" value="cache" id="extra" checked="checked">Borrar cache LiteSpeed por cada plugin activado</p>
                </div>

                <hr>

                <div class="errorLog">
                    <p>
                        <input type="checkbox" name="extra[]"  value="mostrarErrorLog" id="mostrarErrorLog" >
                        <label for="mostrarErrorLog">Mostrar error_log hoy</label>
                    </p>
                    <p>
                        <input type="checkbox" name="extra[]" value="mostrarErrorLog"  id="eliminarErrorLog" >
                        <label for="eliminarErrorLog">Eliminar error_log al desactivar plugins</label>
                    </p>
                    <p>
                        <input type="checkbox" name="extra[]" value="mostrarErrorLog" id="renombrarErrorLog" checked="checked">
                        <label for="renombrarErrorLog">Renombrar error_log al desactivar plugins</label>
                    </p>
                </div>
              
                <div class="btnEnviar">
                    <input type="submit" value="Enviar">
                </div>

            </form>
        </div>
    </div>
     
</body>
</html>