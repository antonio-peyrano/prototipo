/**
 * Esta libreria de scripts contiene las funcionalidades de control del lado cliente
 * sobre la interfaz de ingreso al sistema.
 */

	function validarUsuario(URL,Parametro,Target)
		{
			/*
			 * Esta funcion ejecuta la carga de los elementos que corresponden
			 * al modulo solicitado por el usuario y su perfil para visualizacion.
			 */
			cargarSync(URL,Parametro,Target);
			cargarSync('./php/backend/bl/utilidades/profile.class.php',Parametro,'profile');
			}
