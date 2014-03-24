<center>

	<div id="cabecalho-lista">
		<span id="titulo-lista">Menu</span>
	</div>

<div id="painel">
  <table border="0" align="center" cellpadding="2" cellspacing="2">
  	<tr>
  	 <?php $cont = 0;
  	 		$usuario = $this->Session->read('Auth');//$session->read('Usuario');
			$perfil = $usuario['User']['perfil'];
  	 ?>
	 <?php foreach($menu as $m) {?>
	 	<?php if($cont % 4 == 0) {?>
			</tr>
			<tr>
		<?php } ?>	
		<?php
			$arrayPerfil = $m['perfil'];
			
			if(array_key_exists($perfil,$arrayPerfil)) {
		?>
			
			<td>
				<a href="<?=$m['url'];?>"><?=$this->Html->image($m['imgAtiva']);?></a>
				<br /><br />
				<a href="<?=$m['url'];?>"><?=$m['nome'];?></a>
			</td>
			
		<?php } else { ?>
			 
			<td>
				<?=$this->Html->image($m['imgInativa']);?>
				<br /><br />
				<?=$m['nome'];?>
			</td>
			 
		<?php } ?>
     <?php $cont++;?>
	 <?php } ?>
	 </tr>
  </table>
</div>
</center>