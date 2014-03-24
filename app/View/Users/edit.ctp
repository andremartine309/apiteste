<div id="area-form">
	<?=$this->Form->create('User'); ?>
	<?=$this->Form->input('User.id',array('value'=>$UserAlterar['User']['id'],'label'=>false,'type'=>'hidden'));?>
	<?=$this->Form->input('Usuario.id',array('id'=>'Usuario.id','label'=>false,'type'=>'hidden','value'=>$Usuario['id']));?>
	<div id="cabecalho-lista">
		<span id="titulo-lista">Alteração de Senha do Usuário</span>
	</div>
	
	
	<div id="campos-form">
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="70%">
	  <tr>
		<td align="right">Nome</td>
		<td><?=$Usuario['username'];?></td>
		<?=$this->Form->input('User.username',array('value'=>$UserAlterar['User']['username'],'label'=>false,'type'=>'hidden'));?>
	  </tr>
	  <tr>
		<td align="right">Senha</td>
		<td><?=$this->Form->password('password',array('blank' => true,'label'=>false,'size'=>50,'maxlength'=>50,'error' => array('wrap' => 'span', 'class' => 'erro-form')));?></td>
	  </tr>
	  <tr>
		<td align="right">Perfil</td>
		<td><?=$Usuario['perfil'];?></td>
		<?=$this->Form->input('User.perfis_id',array('value'=>$UserAlterar['User']['perfis_id'],'label'=>false,'type'=>'hidden'));?>
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