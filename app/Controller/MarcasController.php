<?php
	class MarcasController extends AppController {
		public $name = 'Marcas';
		public $uses = array('Marca','User');
		public $components = array('Paginator');
			
		public function index() {
			$this->paginate = 
				array(
						'recursive' => -1,
						'fields' => array(
								'Marca.id',
								'Marca.marca',
								'Marca.data_cadastro',
								'User.username'
						),
						'limit' => 10,
						'order' => array('Marca.marca asc'),
						//'conditions'=> array($filtros),
						'joins' =>
						array(
								array(
										'table' => 'users',
										'alias' => 'User',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Marca.users_id = User.id')
								)
						)
				);
				
			$this->set('Marcas',$this->paginate($this->Marcas));
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
			
		}
		
		function marca_del()
		{
			//var_dump($_POST);exit;
			
			$this->autoLayout = false;
			
			$this->loadModel("Carro");
            $cont = $this->Carro->find('count', array('conditions'=>array('marcas_id'=>$_POST['id']))); 
			
			//Se a exclusão foi realizada com sucesso
			if ($cont == 0) {
				if($this->Marca->delete($_POST['id'])) {
				
					//Gera log de exclusão
					//$this->geraLog('PagDiretor',$tmp['Diretor']['nome'],$this->Session->read('Usuario.login'));	
					
					$this->paginate = 
					array(
							'recursive' => -1,
							'fields' => array(
									'Marca.id',
									'Marca.marca',
									'Marca.data_cadastro',
									'User.username'
							),
							'limit' => 10,
							'order' => array('Marca.marca asc'),
							//'conditions'=> array($filtros),
							'joins' =>
							array(
									array(
											'table' => 'users',
											'alias' => 'User',
											'type' => 'inner',
											'foreignKey' => false,
											'conditions'=> array('Marca.users_id = User.id')
									)
							)
					);
					
					$this->set('Marcas',$this->paginate($this->Marcas));
					
					$Usuario = $this->Session->read('Auth.User');
					$this->set('Usuario',$Usuario);
					
					$mensagem = 'Marca exclu�da com sucesso!';
					$ok  = json_encode(array("tipo" => "ok", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem),'list'=>utf8_encode($this->render('marcas_list'))));
					echo $ok; exit;
					
				}else{
					$mensagem = 'Erro ao tentar excluir a Marca!';
					$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
					echo $erro; exit;
				}
			} else {
				$mensagem = 'Erro ao tentar excluir a Marca. Verifique se n�o existem carros cadastrados para esta marca.';
				$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
				echo $erro; exit;
			}
			
		}
	
		function add()
		{
			
			if($_POST){
				
				//var_dump($_POST['data']);exit;
				
				$this->Marca->create();
				$this->Marca->set('users_id',$_POST['data']['Usuario']['id']);
				$this->Marca->set('data_cadastro',date('Y-m-d'));
				$this->Marca->set('marca',iconv("ISO-8859-1","UTF-8",$_POST['data']['Marca']['marca']));
				
				if($this->Marca->save()) {
				
					//Envia a mensagem de sucesso
					$this->Session->setFlash(iconv("ISO-8859-1","UTF-8",'Marca cadastrada com sucesso!'));
					
					//Direciona para a página inicial da área
					$this->redirect('/Marcas/');

				} else {
				
					//Envia a mensagem de erro
					$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Erro ao cadastrar Marca!'));	
				}
			}
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
		}
		
		function edit($id = null)
		{
			if(!empty($_POST)){
				//ATUALIZA OS DADOS DA MARCA
				//var_dump($_POST['data']);exit;
				
				$this->Marca->create();
				$this->Marca->set('users_id',$_POST['data']['Usuario']['id']);
				$this->Marca->set('data_cadastro',date('Y-m-d'));
				$this->Marca->set('marca',iconv("ISO-8859-1","UTF-8",$_POST['data']['Marca']['marca']));
				
				if($this->Marca->save()) {
				
					//Envia a mensagem de sucesso
					$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Marca atualizada com sucesso!'));
					
					//Direciona para a pagina inicial da area
					$this->redirect('/Marcas/');

				} else {
				
					//Envia a mensagem de erro
					$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Erro ao atualizar Marca!'));	
				}
			}else{
				//BUSCA OS DADOS DA MARCA PARA ATUALIZAR
				$Marca = $this->Marca->find('first',
				array(
						'fields' => array(
								'Marca.id',
								'Marca.marca',
								'Marca.data_cadastro',
					            'User.username'
						),
						'conditions'=> array('Marca.id' => $id),
						'joins' =>
						array(
								array(
										'table' => 'users',
										'alias' => 'User',
										'type' => 'left',
										'foreignKey' => false,
										'conditions'=> array('Marca.users_id = User.id')
								)
						)));
				
				$Marca['Marca']['marca'] = iconv("UTF-8","ISO-8859-1",$Marca['Marca']['marca']);
				$this->data = $Marca;
				
			}
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
		}
	}
?>