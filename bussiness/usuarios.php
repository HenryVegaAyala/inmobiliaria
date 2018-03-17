<?php
class clsUsuario {
	private $objData;
	
	function clsUsuario(){
		$this->objData = new Db();
	}

	function loginUsuario($username, $password){
		$bd = $this->objData;
		// $arrUser = array('idusuario' => 0, 'codigo' => "", 'login' => "", 'foto' => "", 'idperfil' => 0);
		$rs = $bd->exec_sp_select('pa_usuario_login', array($username, $password));
		
		$arrUser['idusuario'] = $rs[0]['tm_idusuario'];
		$arrUser['codigo'] = $rs[0]['tm_codigo'];
		$arrUser['login'] = $rs[0]['tm_login'];
		$arrUser['idperfil'] = $rs[0]['tm_idperfil'];
		$arrUser['idpersona'] = $rs[0]['tm_idpersona'];
		$arrUser['nombreperfil'] = $rs[0]['nombreperfil'];
		$arrUser['foto'] = $rs[0]['tm_foto'];
		$arrUser['idproyecto'] = $rs[0]['tm_idproyecto'];
		
		return $arrUser;
	}

	function Listar($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_usuario_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idusuario, $idperfil, $idpersona, $tipopersona, $login, $nombres, $clave, $apellidos, $sexo, $nrodni, $nroruc, $idlocalidad, $idreccion, $correousuario, $telefono, $foto, $idproyecto, $estadousuario, $idusuarioact, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_usuario_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idusuario, $idperfil, $idpersona, $tipopersona, $login, $nombres, $clave, $apellidos, $sexo, $nrodni, $nroruc, $idlocalidad, $idreccion, $correousuario, $telefono, $foto, $idproyecto, $estadousuario, $idusuarioact));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}

	function CambiarClave($tipo, $current_password, $new_password, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_usuario_cambiarclave';
		$result = $bd->exec_sp_iud($sp_name, array($tipo, $current_password, $new_password, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_usuario_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($listIds, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}

	function Activar($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_usuario_activar';
		$result = $bd->exec_sp_iud($sp_name, array($listIds, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}

	function ToogleState($iditem, $state)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array("activo" => $state), "tm_usuario", "tm_idusuario = ".$iditem);
		return $rpta;
	}

	public function RegisterUserPerfil($idusuario, $idperfil)
	{
		$bd = $this->objData;
		$rpta = 0;
		$entidadPerfilUsuario = array(
			'tm_idperfil' => $idperfil, 
			'tm_idusuario' => $idusuario,
			'idusuarioreg' => 1,
			'fechareg' => date("Y-m-d h:i:s"),
			'idusuarioact' => 1,
			'fechaact' => date("Y-m-d h:i:s")
		);
		$rpta = $bd->set_insert($entidadPerfilUsuario, "td_perfilusuario");
		return $rpta;
	}

	function ObtenerPersona($idusuario)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_usuario_getperson', array($idusuario));
		return $rs;
	}

	function checkUsername($usuario)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_usuario_checking', array($usuario));
		return $rs;
	}
}
?>