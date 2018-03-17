<?php
/**
* 
*/
class clsPerfil
{
	function clsPerfil()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_perfil_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Guardar($idperfil, $nombre, $descripcion, $abreviatura, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_perfil_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idperfil, $nombre, $descripcion, $abreviatura, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}

	function Eliminar($idperfil, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_perfil_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($idperfil, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomensaje = $result[0]['contenidomensaje'];
		return 1;
	}

	function RegistrarPerfilMenu($idperfil, $listIdMenu, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_perfil_menu_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idperfil, $listIdMenu, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomensaje = $result[0]['contenidomensaje'];
		return 1;
	}

	function PerfilUsuarioListar($tipo, $idperfil, $idusuario)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_perfil_usuario_listar', array($tipo, $idperfil, $idusuario));
		return $rs;
	}
}
?>