<?php
	class CarrosController extends AppController {
		public $name = 'Carros';
		public $uses = array('Carro','Marca','User','Foto');
		public $components = array('Paginator');
			
		public function index() {
			$this->paginate = 
				array(
						'recursive' => -1,
						'fields' => array(
								'Carro.id',
								'Carro.modelo_carro',
								'Carro.ano',
								'Carro.valor',
								'Carro.nr_parcelas',
								'Carro.data_cadastro',
								'Carro.foto',
								'Marca.marca',
								'User.username'
						),
						'limit' => 10,
						'order' => array('Carro.id asc'),
						//'conditions'=> array($filtros),
						'joins' =>
						array(
								array(
										'table' => 'users',
										'alias' => 'User',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Carro.users_id = User.id')
								),
								array(
										'table' => 'marcas',
										'alias' => 'Marca',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Carro.marcas_id = Marca.id')
								)
						)
				);
				
			$this->set('Carros',$this->paginate($this->Carros));
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
			
		}
		
		function carro_del()
		{
			//var_dump($_POST);exit;
			
			$this->autoLayout = false; 
			
			//Se a exclusÃ£o foi realizada com sucesso
			if($this->Carro->delete($_POST['id'])) {
				
				//Gera log de exclusÃ£o
				//$this->geraLog('PagDiretor',$tmp['Diretor']['nome'],$this->Session->read('Usuario.login'));	
				
				$this->paginate = 
				array(
						'recursive' => -1,
						'fields' => array(
								'Carro.id',
								'Carro.modelo_carro',
								'Carro.ano',
								'Carro.valor',
								'Carro.nr_parcelas',
								'Carro.data_cadastro',
								'Carro.foto',
								'Marca.marca',
								'User.username'
						),
						'limit' => 10,
						'order' => array('Carro.id asc'),
						//'conditions'=> array($filtros),
						'joins' =>
						array(
								array(
										'table' => 'users',
										'alias' => 'User',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Carro.users_id = User.id')
								),
								array(
										'table' => 'marcas',
										'alias' => 'Marca',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Carro.marcas_id = Marca.id')
								)
						)
				);
				
				$this->set('Carros',$this->paginate($this->Carros));
				
				$Usuario = $this->Session->read('Auth.User');
				$this->set('Usuario',$Usuario);
				
				$mensagem = 'Carro excluído com sucesso!';
				$ok  = json_encode(array("tipo" => "ok", "msg"=>$mensagem,'list'=>utf8_encode($this->render('carros_list'))));
				echo $ok; exit;
				
			}else{
				$mensagem = 'Erro ao tentar excluir o Carro!';
				$erro  = json_encode(array("tipo" => "erro", "msg"=>$mensagem));
				echo $erro; exit;
			}
		}
	
		function add()
		{
			
			if($_POST){
				
				//var_dump($_POST['data']);exit;
				
				$this->Carro->create();
				$this->Carro->set('users_id',$_POST['data']['Usuario']['id']);
				$this->Carro->set('data_cadastro',date('Y-m-d'));
				$_POST['data']['Carro']['modelo_carro'] = iconv("ISO-8859-1","UTF-8",$_POST['data']['Carro']['modelo_carro']);
				
				//Validações
				$msgErro = "";
				$OK = true;
				
				//Marca
				if (empty($_POST['data']['Carro']['marcas_id'])){
					$msgErro .= "Você deve selecionar uma marca de carro.<br />";
					$msgErro .= "Caso não tenha cadastrado nenhuma marca, clique <a href=\"/apiteste/Marcas/add\">aqui</a>.<br />";
					$OK = false;
				}
				
				//Modelo
				if (empty($_POST['data']['Carro']['modelo_carro'])){
					$msgErro .= "Você deve informar o modelo do carro.<br />";
					$OK = false;
				}
					
				
				//Valor do Carro
				$_POST['data']['Carro']['valor'] = str_replace(',','.',$_POST['data']['Carro']['valor']);
				if (!is_numeric($_POST['data']['Carro']['valor'])){
					$msgErro .= "O valor do carro deve ser numérico.<br />";
					$OK = false;
				}
				
				//Ano
				if (!is_numeric($_POST['data']['Carro']['ano'])){
					$msgErro .= "O ano deve ser numérico.<br />";
					$OK = false;
				}
				
				if ($OK === true){
					if($this->Carro->save($_POST['data'])) {
					
						//Envia a mensagem de sucesso
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Carro cadastrado com sucesso!'));
						
						//Direciona para a pÃ¡gina inicial da Ã¡rea
						$this->redirect('/Carros/');
	
					} else {
					
						//Envia a mensagem de erro
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Erro ao cadastrar Carro!'));	
					}
				}else{
					//Envia a mensagem de erro
					$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",$msgErro));
				}
					
			}
			
			//Seleciona Marcas para inclusão
			$arrtemp = $this->Marca->find('list',array('fields' => array('id','marca'),'order' => array('marca ASC')));
			foreach($arrtemp as $key => $val)
			{
				$marcas[$key] = iconv("UTF-8","ISO-8859-1",$val);
			}
			$this->set('selectMarcas',$marcas);
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
		}
		
		function edit($id = null)
		{
			if(!empty($_POST)){
				//ATUALIZA OS DADOS DO CARRO
				//var_dump($_POST['data']);exit;
				
				$this->Carro->create();
				$this->Carro->set('users_id',$_POST['data']['Usuario']['id']);
				$this->Carro->set('data_cadastro',date('Y-m-d'));
				$_POST['data']['Carro']['modelo_carro'] = iconv("ISO-8859-1","UTF-8",$_POST['data']['Carro']['modelo_carro']);
				
				//Validações
				$msgErro = "";
				$OK = true;
				
				//Modelo
				if (empty($_POST['data']['Carro']['marcas_id'])){
					$msgErro .= "Você deve selecionar uma marca de carro.<br />";
					$OK = false;
				}
					
				
				//Valor do Carro
				$_POST['data']['Carro']['valor'] = str_replace(',','.',$_POST['data']['Carro']['valor']);
				if (!is_numeric($_POST['data']['Carro']['valor'])){
					$msgErro .= "O valor do carro deve ser numérico.<br />";
					$OK = false;
				}
				
				//Ano
				if (!is_numeric($_POST['data']['Carro']['ano'])){
					$msgErro .= "O ano deve ser numérico.<br />";
					$OK = false;
				}
				
				if ($OK === true){
					if($this->Carro->save($_POST['data'])) {
					
						//Envia a mensagem de sucesso
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Carro editado com sucesso!'));
						
						//Direciona para a página inicial da área
						$this->redirect('/Carros/');
	
					} else {
					
						//Envia a mensagem de erro
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Erro ao editar Carro!'));	
					}
				}else{
					//Envia a mensagem de erro
					$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",$msgErro));
				}
			}else{
				//BUSCA OS DADOS PARA ATUALIZAR
				$Carro = $this->Carro->find('first',
				array(
						'fields' => array(
								'Carro.id',
								'Carro.marcas_id',
								'Carro.modelo_carro',
								'Carro.ano',
								'Carro.valor',
								'Carro.nr_parcelas',
								'Carro.data_cadastro',
								'Carro.foto',
								'Marca.marca',
								'User.username'
						),
						'conditions'=> array('Carro.id' => $id),
						'joins' =>
						array(
								array(
										'table' => 'users',
										'alias' => 'User',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Carro.users_id = User.id')
								),
								array(
										'table' => 'marcas',
										'alias' => 'Marca',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Carro.marcas_id = Marca.id')
								)
						)));
			
				$this->data = $Carro;
			}
			
			//Seleciona Marcas para inclusão
			$arrtemp = $this->Marca->find('list',array('fields' => array('id','marca'),'order' => array('marca')));
			foreach($arrtemp as $key => $val)
			{
				$marcas[$key] = iconv("UTF-8","ISO-8859-1",$val);
			}
			$this->set('selectMarcas',$marcas);
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
		}

		function view($id = null)
		{
			
			//BUSCA OS DADOS PARA MOSTRAR
			$Carro = $this->Carro->find('first',
			array(
					'fields' => array(
							'Carro.id',
							'Carro.marcas_id',
							'Carro.modelo_carro',
							'Carro.ano',
							'Carro.valor',
							'Carro.nr_parcelas',
							'Carro.data_cadastro',
							'Carro.foto',
							'Marca.marca',
							'User.username'
					),
					'conditions'=> array('Carro.id' => $id),
					'joins' =>
					array(
							array(
									'table' => 'users',
									'alias' => 'User',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions'=> array('Carro.users_id = User.id')
							),
							array(
									'table' => 'marcas',
									'alias' => 'Marca',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions'=> array('Carro.marcas_id = Marca.id')
							)
					)));
		
			$this->data = $Carro;
			
			$fotos = $this->Foto->find('all', array('fields' => array('id', 'carros_id', 'nome', 'tipo', 'data_cadastro'),'conditions' => array ('Foto.carros_id' => $id)));
			$this->set('Fotos',$fotos);
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
		}
	}
?>