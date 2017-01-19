/*
 * Prototipo v1.0.0 Software base para desarrollo de sistemas.
 * PHP v5
 * Autor: Prof. Jesus Antonio Peyrano Luna <antonio.peyrano@live.com.mx>
 * Nota aclaratoria: Este programa se distribuye bajo los terminos y disposiciones
 * definidos en la GPL v3.0, debidamente incluidos en el repositorio original.
 * Cualquier copia y/o redistribucion del presente, debe hacerse con una copia
 * adjunta de la licencia en todo momento.
 * Licencia: http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

Create table opUsrTemp (
	idUsrtmp Int NOT NULL AUTO_INCREMENT,
	idNivel Int NOT NULL,
	Usuario Varchar(250) NOT NULL,
	Clave Varchar(250) NOT NULL,
	Correo Varchar(250) NOT NULL,
	Pregunta Varchar(250) NOT NULL,
	Respuesta Varchar(250) NOT NULL,
	Status Int NOT NULL DEFAULT 0,
 Index idxUrstmp (idUsrtmp),
 Primary Key (idUsrtmp)) ENGINE = MyISAM;

Create table catNiveles (
	idNivel Int NOT NULL AUTO_INCREMENT,
	Nivel Varchar(250) NOT NULL,
	Status Int NOT NULL DEFAULT 0,
 Index idxNivel (idNivel),
 Primary Key (idNivel)) ENGINE = MyISAM;

Create table catUsuarios (
	idUsuario Int NOT NULL AUTO_INCREMENT,
	idNivel Int NOT NULL,
	Usuario Varchar(250) NOT NULL,
	Clave Varchar(250) NOT NULL,
	Correo Varchar(250) NOT NULL,
	Pregunta Varchar(250) NOT NULL,
	Respuesta Varchar(250) NOT NULL,
	Status Int NOT NULL DEFAULT 0,
 Index idxUsuario (idUsuario),
 Primary Key (idUsuario)) ENGINE = MyISAM;

Create table catModulos (
	idModulo Int NOT NULL AUTO_INCREMENT,
	Modulo Varchar(250) NOT NULL,
	URL Varchar(250) NOT NULL,
	Status Int NOT NULL DEFAULT 0,
 Index idxModulo (idModulo),
 Primary Key (idModulo)) ENGINE = MyISAM;

Create table opRelPerUsr (
	idRelPerUsr Int NOT NULL AUTO_INCREMENT,
	idUsuario Int NOT NULL,
	idModulo Int NOT NULL,
	Status Int NOT NULL DEFAULT 0,
 Index idxRelPerUsr (idRelPerUsr),
 Primary Key (idRelPerUsr)) ENGINE = MyISAM;