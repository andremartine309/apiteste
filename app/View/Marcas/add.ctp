<?php //var_dump($Usuario);exit; ?>
<div id="area-form">
	<?=$this->Form->create('Marca'); ?>
	<?=$this->Form->input('Usuario.id',array('id'=>'Usuario.id','label'=>false,'type'=>'hidden','value'=>$Usuario['id']));?>
	<div id="cabecalho-lista">
		<span id="titulo-lista">Inclusão de Marcas</span>
	</div>
	
	
	<div id="campos-form">
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="70%">
	  <tr>
		<td align="right">Marca</td>
		<td><?=$this->Form->input('marca',array('label'=>false,'size'=>50,'maxlength'=>50,'error' => array('wrap' => 'span', 'class' => 'erro-form')));?></td>
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