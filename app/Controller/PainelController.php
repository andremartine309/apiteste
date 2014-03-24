<?php
	class PainelController extends AppController {
		public $name = 'Painel';
			
		public function index()
		{	
			$menu = array(
					'marcas'=>array(
								'imgAtiva' => 'icon_matriz.jpg',
								'imgInativa' => 'icon_matriz_cinza.jpg',
								'url' => 'marcas',
								'nome' => 'Marcas de Carros',
								'perfil' => array('Admin' => 'admin','Funcion�rio' => 'Funcion�rio')
								),
					'carros'=>array(
								'imgAtiva' => 'icon_empreendimento.jpg',
								'imgInativa' => 'icon_empreendimento_cinza.jpg',
								'url' => 'carros',
								'nome' => 'Carros',
								'perfil' => array('Admin' => 'admin', 'Funcion�rio' => 'Funcion�rio')
								),
					'users'=>array(
								'imgAtiva' => 'icon_perfil.gif',
								'imgInativa' => 'icon_perfil_cinza.gif',
								'url' => 'users',
								'nome' => 'Usu�rios',
								'perfil' => array('Admin' => 'admin')
								),
					'logs'=>array(
								'imgAtiva' => 'icon_subarea.gif',
								'imgInativa' => 'icon_subarea_cinza.gif',
								'url' => 'logs',
								'nome' => 'Logs',
								'perfil' => array('Admin' => 'admin', 'Funcion�rio' => 'Funcion�rio')
								)
				);
			$this->set('menu',$menu);
		}
	}
?>