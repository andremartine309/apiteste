<?php
	//var_dump($this->data);
?>
<script type="text/javascript">
    $(document).ready(function(){
        $(function() {
			$( "#ano" ).datepicker({changeYear: true});
			$( "#ano" ).datepicker("option", "dateFormat", 'yy');
			$( "#ano" ).datepicker( "option",$.datepicker.regional[ "pt-BR" ] );
		});
    });
</script>

<?php //var_dump($Usuario);exit; ?>
<div id="area-form">
	<?=$this->Form->create('Carro'); ?>
	<?=$this->Form->input('Carro.id',array('label'=>false,'type'=>'hidden'));?>
	<?=$this->Form->input('Usuario.id',array('id'=>'Usuario.id','label'=>false,'type'=>'hidden','value'=>$Usuario['id']));?>
	<div id="cabecalho-lista">
		<span id="titulo-lista">Edição de Carros</span>
	</div>
	
	<div id="campos-form">
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="70%">
        <tr>
			<td align="right">Marca</td>
			<td><?=$this->Form->input('Carro.marcas_id', array(
					'label' => false,
				    'options' => array($selectMarcas),
				    'empty' => '--- SELECIONE ---'
				));?></td>
		  </tr>
		<tr>
			<td align="right">Modelo</td>
			<td><?=$this->Form->input('Carro.modelo_carro',array('label'=>false,'size'=>50,'maxlength'=>50,'error' => array('wrap' => 'span', 'class' => 'erro-form')));?></td>
		</tr>
		<tr>
			<td align="right">Ano</td>
			<td><?=$this->Form->input('Carro.ano',array('id'=>'ano','value'=>$this->data['Carro']['ano'],'label'=>false,'size'=>4,'maxlength'=>4,'error' => array('wrap' => 'span', 'class' => 'erro-form')));?>
		</tr>
		<tr>
			<td align="right">Valor</td>
			<?php if(array_key_exists($Usuario['perfil'], array_flip(array('Admin')))) { ?>
				<td><?=$this->Form->input('Carro.valor',array('id'=>'valor','value'=>str_replace('.', ',', $this->data['Carro']['valor']),'label'=>false,'size'=>20,'maxlength'=>19,'error' => array('wrap' => 'span', 'class' => 'erro-form')));?></td>
			<?php }else{?>
				<td><?=str_replace('.', ',', 'R$ '.$this->data['Carro']['valor']);?></td>
				<?=$this->Form->input('Carro.valor',array('label'=>false,'type'=>'hidden'));?>
			<?php } ?>
		</tr>
		<tr>
			<td align="right">Nº de Parcelas </td>
			<td><?=$this->Form->input('Carro.nr_parcelas', array('label' => false,'options' => array(
								''=>"--- SELECIONE ---",
								'3'=>'3',
								'6'=>'6',
								'12'=>'12'
							)));?></td>
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