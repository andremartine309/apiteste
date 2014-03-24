<div id="area-form">
	<?=$this->Form->create('User'); ?>
	<div id="cabecalho-lista">
		<span id="titulo-lista">Inclusão de Usuários do Sistema</span>
	</div>
	
	
	<div id="campos-form">
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="70%">
	  <tr>
		<td align="right">Nome</td>
		<td><?=$this->Form->input('username',array('label'=>false,'size'=>50,'maxlength'=>50,'error' => array('wrap' => 'span', 'class' => 'erro-form')));?></td>
	  </tr>
	  <tr>
		<td align="right">Senha</td>
		<td><?=$this->Form->password('password',array('blank' => true,'label'=>false,'size'=>50,'maxlength'=>50,'error' => array('wrap' => 'span', 'class' => 'erro-form')));?></td>
	  </tr>
	  <tr>
		<td align="right">Perfil</td>
		<td><?=$this->Form->input('perfis_id', array(
		    'options' => array($selectPerfis),
		    'empty' => '--- SELECIONE ---'
		));?></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<div id="botao-gravar">
			<?=$this->Form->submit('Gravar');?>
			</div>
		</td>
	  </tr>
	</table>	
	<?=$this->Form->end(); ?>
	</div>
</div>