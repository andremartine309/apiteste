<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AuthComponent', 'Controller/Component');
$cakeDescription = __d('cake_dev', 'API TESTE');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('default');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('jquery-ui');
		
		echo $this->Html->css('black-tie/jquery.ui');
		echo $this->Html->script('jquery-1.9.1');
		echo $this->Html->script('jquery-ui');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="areal-geral">
		<div id="container">
			<div id="header">
				<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
			</div>
			<!--<div id="content">-->
	
				<center><?php $flash = $this->Session->flash(); if (!empty($flash)) echo $flash ?></center>
				
				<div id="barra-auxiliar">
				
					<?php 
						$Usuario = $this->Session->read('Auth.User');
						if(isset($Usuario)) {?>
					<div>
					    <table border="0" cellspacing="0" cellpadding="0">
			            	<tr>
				                <td><?=$this->Html->image('icon_painel.png');?></td>
				                <td><span><?=$this->Html->link('Menu','/painel')?></span></td>
				                <td><?=$this->Html->image('icon_login.gif');?></td>
				                <td><span><?=$Usuario['username']?>&nbsp;/&nbsp;<?=($Usuario['perfil'] == 'Admin') ? 'Admin' : 'Funcionário'?></span></td>
				                <td><?=$this->Html->image('icon_chave.gif');?></td>
								<td><span><?=$this->Html->link('Alterar senha','/Users/edit/'.$Usuario['id'])?></span></td>
								<td><?=$this->Html->image('botao_sair.gif');?></td>
				                <td><span><?=$this->Html->link('Sair','/Users/logout')?></span></td>
			              	</tr>
		              	</table>
				  	</div>
				  	<?php }else{
	                    echo $this->Html->image('icon_login.gif');
	                    echo $this->Html->link('Login','login');
	               	}?>
				
					<div id="conteudo">
						<?php echo $this->fetch('content'); ?>
					</div>
			</div>
			<div id="footer">
				<?php echo $this->Html->link(
						$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
						'http://www.cakephp.org/',
						array('target' => '_blank', 'escape' => false)
					);
				?>
			<!--</div>-->
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
