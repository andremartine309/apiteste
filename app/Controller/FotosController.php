<?php
	class FotosController extends AppController {
		public $name = 'Fotos';
		public $uses = array('Foto','Carro');
		public $components = array('Paginator');
		public $helpers = array('Js' => array('Jquery'),'Html');
			
		public function index() {
			//Não tem index pois será utilizado para incluir fotos dos Carros
		}
			
		function foto_add()
		{
			$this->autoLayout = false; 
			//var_dump($_POST);exit;
			
			$uploaddir = '../webroot/fotos_carros/';
			 
						
			if (!empty($_FILES))
			{
				
				$id = $_POST['data']['Carro']['id'];
				$arquivo = $_FILES['data'];
				//$var = preg_replace($acentos, array_keys($acentos), $arquivo['name']);
				//$nome = strtolower($var);
				$nome = strtolower($arquivo['name']['Foto']['arquivo']);
				
				$file = array('name'=>$nome,
			    			  'type'=>$arquivo['type']['Foto']['arquivo'],
			    			  'tmp_name'=>$arquivo['tmp_name']['Foto']['arquivo'],
			    			  'error'=>$arquivo['error']['Foto']['arquivo'],
			    			  'size'=>$arquivo['size']['Foto']['arquivo'],
							);
				
				$ext = strtolower(substr($file['name'],strlen($file['name'])-3,3));
				
				//var_dump($file);exit;
				//echo "EXTENSAO: ".$ext;exit;
				
				//Imagens (.jpg, .png, .bmp, .gif).
				if (($ext != "jpg") && ($ext != "jpeg") && ($ext != "png") && ($ext != "gif"))
				{
					$mensagem = "Não foi possível fazer o upload do arquivo! <br />".  
							    "Arquivo com extensão ." . $ext . " não suportada. <br />".
							    "Extensões de aceitas: .jpg, .jpeg, .png, .gif<br />";
								
					$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
					
					echo $erro; exit;
				}
				else
				{
					//var_dump($uploaddir . $file['name']);exit;
					//copia o arquivo para o destino e salva os dados no banco
					$nome_arquivo = $id . '_' . date('Y-m-d_H_i') . '_' . $file['name'];
					if (move_uploaded_file($file['tmp_name'], $uploaddir . $nome_arquivo)){
						if (!empty($id))
						{
							echo "ID".$id;
							$arquivo = array('id'=>null, 
											 'carros_id'=>$id, 
											 'nome'=>iconv("UTF-8","ISO-8859-1",$nome_arquivo),
											 'tipo'=>$ext,
											 'caminho'=>iconv("UTF-8","ISO-8859-1",stripslashes($uploaddir . $nome_arquivo)),
											 'tamanho'=>$file['size'],
											 'data_cadastro'=>date('Y-m-d H:i')
											 );
							
							if ($this->Foto->save($arquivo))
							{
								$fotos = $this->Foto->find('all', array('fields' => array('id', 'carros_id', 'nome', 'tipo', 'data_cadastro'),'conditions' => array ('Foto.carros_id' => $id)));
								$this->set('Fotos',$fotos);
								
								$Usuario = $this->Session->read('Auth.User');
								$this->set('Usuario',$Usuario);
								
								echo utf8_encode($this->render('fotos_list')); exit;
								
							}
							else
							{
								$mensagem = "Ocorreu um erro ao salvar o registro da foto no Banco de Dados. Por favor, tente novamente.";
								$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
								echo $erro; exit;
							}
						}
						else
						{
							$mensagem = "O registro do Carro não foi encontrado. Por favor, verifique se não foi excluído.";
							$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
							echo $erro; exit;
						}
					}
					else
					{
						$mensagem = "Não foi possível salvar o arquivo no destino. Favor verificar as permissões da pasta de destino.";
						$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
						echo $erro; exit;
					}
				}
			}
		}
		
		function add($id)
		{
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
			
			$this->set('Carro',$Carro);
				
			$fotos = $this->Foto->find('all', array('fields' => array('id', 'carros_id', 'nome', 'tipo', 'data_cadastro'),'conditions' => array ('Foto.carros_id' => $id)));
			$this->set('Fotos',$fotos);
			
			$Usuario = $this->Session->read('Auth.User');
			$this->set('Usuario',$Usuario);
		}
		
		
		function foto_del()
		{
			$this->autoLayout = false; 
			//var_dump($_POST);exit;
			$carros_id = $_POST['carros_id'];
			//busca o registro da foto para excluir o arquivo do diretório
			$foto = $this->Foto->find('first', array('fields' => array('id', 'carros_id', 'nome', 'caminho', 'tipo', 'data_cadastro'),'conditions' => array ('Foto.id' => $_POST['id'])));
			
			$foto = $foto['Foto'];
			
			if(!empty($foto)){
				//var_dump($foto);exit;
				$result = glob($foto['caminho']);
				if (!empty($result)) { 
					unlink($foto['caminho']);
				
					//Se a exclusão foi realizada com sucesso
					if($this->Foto->delete($_POST['id'])) {
						$fotos = $this->Foto->find('all', array('fields' => array('id', 'carros_id', 'nome', 'caminho', 'tipo', 'data_cadastro'),'conditions' => array ('Foto.carros_id' => $carros_id)));
						$this->set('Fotos',$fotos);
						
						$Usuario = $this->Session->read('Auth.User');
						$this->set('Usuario',$Usuario);
						
						$mensagem = 'Foto Excluída com sucesso!';
						$ok  = json_encode(array("tipo" => "ok", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem), "list"=>utf8_encode($this->render('fotos_list'))));
						echo $ok; exit;
					}else{
						$mensagem = 'Erro ao tentar excluir a Foto do Banco de Dados!';
						$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
						echo $erro; exit;
					}
				}
				else
				{
					$mensagem = 'Erro ao tentar excluir a Foto do Diretório!';
					$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
					echo $erro; exit;
				}
			}
			else
			{
				$mensagem = 'A Foto não foi localizado no Banco de Dados!';
				$erro  = json_encode(array("tipo" => "erro", "msg"=>iconv("ISO-8859-1","UTF-8",$mensagem)));
				echo $erro; exit;	
			}
		}
	
	}
?>