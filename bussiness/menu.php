<?php
class clsMenu {
    private $objData;
	
	function clsMenu(){
		$this->objData = new Db();
	}

	function ListMenuPerfil($tipo, $idperfil, $idreferencia, $tipomenu)
	{
		$bd = $this->objData;
		if ($tipo == 'CONFIG')
			$rs = $bd->exec_sp_select('pa_perfilmenu_config', array($idperfil));
		else
			$rs = $bd->exec_sp_select('pa_perfilmenu_home_v2', array($idperfil, $tipomenu, $idreferencia, $tipo));
		return $rs;
	}
}
?>