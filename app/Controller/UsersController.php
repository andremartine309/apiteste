<?php

	App::uses('AuthComponent', 'Controller/Component');
	App::import('Controller', 'Logs');
	
	class UsersController extends AppController {
		public $name = 'Users';
		//public $uses = array('User','Perfil');
		public $uses = array('User','Perfil','Log');
		public $components = array('Paginator');
			
		public function index() {
			$this->paginate = 
				array(
						'recursive' => -1,
						'fields' => array(
								'User.id',
								'User.username',
								'Perfil.nome_perfil'
						),
						'limit' => 10,
						'order' => array('User.username asc'),
						//'conditions'=> array($filtros),
						'joins' =>
						array(
								array(
										'table' => 'perfis',
										'alias' => 'Perfil',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('User.perfis_id = Perfil.id')
								)
						)
				);
				
			$this->set('Users',$this->paginate($this->Users));
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
			
		}
		
		function user_del()
		{
			//var_dump($_POST);exit;
			$this->autoLayout = false; 
			
			$this->loadModel("Carro");
			$this->loadModel("Marca");
            $cont = $this->Carro->find('count', array('conditions'=>array('users_id'=>$_POST['id']))); 
			$cont += $this->Marca->find('count', array('conditions'=>array('users_id'=>$_POST['id'])));
			
			
			if ($cont == 0)
			{
				//Se a exclusão foi realizada com sucesso
				if($this->User->delete($_POST['id'])) {
					
					//Gera log de exclusão
					//$this->geraLog('PagDiretor',$tmp['Diretor']['nome'],$this->Session->read('Usuario.login'));	
					
					$this->paginate = 
						array(
								'recursive' => -1,
								'fields' => array(
										'User.id',
										'User.username',
										'Perfil.nome_perfil'
								),
								'limit' => 10,
								'order' => array('User.username asc'),
								//'conditions'=> array($filtros),
								'joins' =>
								array(
										array(
												'table' => 'perfis',
												'alias' => 'Perfil',
												'type' => 'inner',
												'foreignKey' => false,
												'conditions'=> array('User.perfis_id = Perfil.id')
										)
								)
						);
						
					$this->set('Users',$this->paginate($this->Users));
					
					$Usuario = $this->Session->read('Auth.User');
					$this->set('Usuario',$Usuario);
					
					$mensagem = 'Usuário excluído com sucesso!';
					$ok  = json_encode(array("tipo" => "ok", "msg"=>$mensagem,'list'=>utf8_encode($this->render('users_list'))));
					echo $ok; exit;
					
				}else{
					$mensagem = 'Erro ao tentar excluir o Usuário!';
					$erro  = json_encode(array("tipo" => "erro", "msg"=>$mensagem));
					echo $erro; exit;
				}
			}else{
				$mensagem = 'Erro ao tentar excluir o Usuário. Existem registros de Marcas e/ou Carros sob responsabilidade deste usuário. Edite esses registros e tente excluir o usuário novamente.';
				$erro  = json_encode(array("tipo" => "erro", "msg"=>$mensagem));
				echo $erro; exit;
			}

			
		}
	
		function add()
		{
			
			if($_POST){
				
				//var_dump($_POST['data']);exit;		 
						
				//Validações
				$msgErro = "";
				$OK = true;
				
				//Perfil
				if (empty($_POST['data']['User']['perfis_id'])){
					$msgErro .= "Você deve selecionar um perfil.<br />";
					$OK = false;
				}
				
				if ($OK === true){			
					if($this->User->save($_POST['data'])) {
					
						//Envia a mensagem de sucesso
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Usuário cadastrado com sucesso!'));
						
						//Direciona para a página inicial da área
						$this->redirect('/Users/');
	
					} else {
					
						//Envia a mensagem de erro
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Erro ao cadastrar Usuário!'));	
					}
				}else{
					//Envia a mensagem de erro
					$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",$msgErro));	
				}
			}
			
			//Seleciona Perfis para inclusão
			$arrtemp = $this->Perfil->find('list',array('fields' => array('id','nome_perfil'),'order' => array('nome_perfil')));
			foreach($arrtemp as $key => $val)
			{
				$perfis[$key] = iconv("UTF-8","ISO-8859-1",$val);
			}
			//var_dump($perfis);exit;
			$this->set('selectPerfis',$perfis);	
		}
		
		function edit($id = null)
		{
			if($_POST){
				
				//var_dump($_POST['data']);exit;
				
				//busca o usuário logado para comparar com os dados inseridos (ID a ser alterado)
				$Usuario = $this->Session->read('Auth.User');
				$this->set('Usuario',$Usuario);
				
				if ($Usuario['id'] == $_POST['data']['User']['id']){			
					if($this->User->save($_POST['data']['User'])) {
					
						//Envia a mensagem de sucesso
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Usuário cadastrado com sucesso!'));
						
						//Direciona para a página inicial da área
						$this->redirect('/Users/');
	
					} else {
					
						//Envia a mensagem de erro
						$this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Erro ao cadastrar Usuário!'));	
					}
				}else{
					//Envia a mensagem de erro
					$this->Session->setFlash(iconv("UTF-8","ISO-8859-1","Você está tentando alterar a senha de outro usuário. Efetue logout, depois login e tente novamente."));	
				}
			}else{
				$User = $this->User->find('first',
					array('fields' => array('User.id','User.username','User.perfis_id','Perfil.nome_perfil'),
					'joins' =>
						array(
								array(
										'table' => 'perfis',
										'alias' => 'Perfil',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('User.perfis_id = Perfil.id')
								)
						),
					'conditions' => array('User.id' => $id)
					));
				$this->set('UserAlterar',$User);	 
					
				$Usuario = $this->Session->read('Auth.User');
				$this->set('Usuario',$Usuario);
			}
				
		}
		
		public function beforeFilter() {
		    parent::beforeFilter();
		}
		
		public function login() {
		    if ($_POST){
			    if ($this->Auth->login()) {
			        //$this->redirect($this->Auth->redirect());
			        
			        //registra o log de acesso
			        $Usuario = $this->Session->read('Auth.User');
			        
					$Logs = new LogsController;
					$Logs->add_log($Usuario);
			        
			        //redireciona para o painel de controle
			        $this->redirect('/painel');
			    } else {
			        $this->Session->setFlash(iconv("UTF-8","ISO-8859-1",'Nome de usuário ou senha inválida, tente novamente'));
			    }
			}
		}
		
		public function logout() {
		    $this->redirect($this->Auth->logout());
		}
	}
?>