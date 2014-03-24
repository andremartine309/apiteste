<?php
	//var_dump($this->data);
?>

<script type="text/javascript">
    $(document).ready(function(){
        //$('#cal').datepicker();
    });
</script>

<?php //var_dump($Usuario);exit; ?>
<div id="area-form">
	<?=$this->Form->create('Carro'); ?>
	<?=$this->Form->input('Carro.id',array('label'=>false,'type'=>'hidden'));?>
	<?=$this->Form->input('Usuario.id',array('id'=>'Usuario.id','label'=>false,'type'=>'hidden','value'=>$Usuario['id']));?>
	<div id="cabecalho-lista">
		<span id="titulo-lista">Visualização de Carros</span>
	</div>
	
	<div id="campos-form">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="70%">
	        <tr>
			<td align="right">Marca</td>
				<td><?=$this->data['Marca']['marca'];?></td>
			  </tr>
			<tr>
				<td align="right">Modelo</td>
				<td><?=$this->data['Carro']['modelo_carro'];?></td>
			</tr>
			<tr>
				<td align="right">Ano</td>
				<td><?=$this->data['Carro']['ano'];?>
			</tr>
			<tr>
				<td align="right">Valor</td>
				<td><?=str_replace('.', ',', 'R$ '.$this->data['Carro']['valor']);?></td>
			</tr>
			<tr>			
			  	<td align="right">Nº de Parcelas </td>
		      	<td><?=$this->data['Carro']['nr_parcelas'];?></td>
	        </tr>
		</table>	
		<?=$this->Form->end(); ?>
	
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="90%">
			<tr>
				<th>Id</th>
			    <th class="alinha-esquerda">Nome</th>
			    <th>Tipo</th>	    
			    <th>Data</th>
			    <th>Imagem</th>
			   	<th colspan="3">A&ccedil;&atilde;o</th>
			</tr>
			
			<?php foreach($Fotos as $foto) { ?>
			  <tr>
			    <td><?=$foto['Foto']['id'];?></td>
			    <td class="alinha-esquerda"><?=strtoupper($foto['Foto']['nome']);?></td>
			    <td><?=$foto['Foto']['tipo'];?></td>
			    <td><?=$foto['Foto']['data_cadastro'];?></td>
			    <td><?=$this->Html->image('/fotos_carros/'.$foto['Foto']['nome'],array('width'=>'300px'));?></td>
				<td>
				<?php
					if(array_key_exists($Usuario['perfil'], array_flip(array('Admin')))) {
						echo $this->Html->image('b_del.png',array('title'=>'Excluir Foto','onClick' => '$().excluirFoto('.$foto['Foto']['id'].')'));
					} else {
						echo $this->Html->image('b_del_cinza.png',array('title'=>'Excluir Foto'),array('onClick' => 'alert("Operação negada para esse Perfil de Usuário!")'));
					}
				?>	
				</td>
				</tr>
			 <?php } ?>
		</table>
	</div>
</div>