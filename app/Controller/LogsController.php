<?php
	class LogsController extends AppController {
		public $name = 'Logs';
		public $uses = array('Log','User');
		public $components = array('Paginator');
			
		public function index() {
			$this->paginate = 
				array(
						'recursive' => -1,
						'fields' => array(
								'Log.id',
								'Log.data_log',
								'User.username'
						),
						'limit' => 10,
						//'conditions'=> array($filtros),
						'joins' =>
						array(
								array(
										'table' => 'users',
										'alias' => 'User',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions'=> array('Log.users_id = User.id')
								)
						),
						'order' => array('Log.data_log')
				);
				
			$this->set('Logs',$this->paginate($this->Logs));
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
			
		}
		
		function add_log($Usuario)
		{
			
			if($_POST){
				
				//var_dump($_POST['data']);exit;
				
				$this->Log->create();
				$this->Log->set('users_id',$Usuario['id']);
				$this->Log->set('data_log',date('Y-m-d H:i'));
				if($this->Log->save($_POST['data'])) {
					return true;
				}else{
					return false;	
				}
					
			}
		}

	}
?>