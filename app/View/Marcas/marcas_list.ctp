<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  		<tr>
			    <th>Id</th>
			    <th class="alinha-esquerda">Marca</th>
			    <th>Data do Cadastro</th>
			    <th>Usuário Responsável</th>
			    <th colspan="5">A&ccedil;&atilde;o</th>
	  		</tr>
  		
  		
	  		<?php foreach($Marcas as $marca) { ?>
	  		<tr>
			    <td><?=$marca['Marca']['id'];?></td>
			    <td class="alinha-esquerda"><?=iconv("UTF-8","ISO-8859-1",$marca['Marca']['marca']);?></td>
			    <td><?=date("d/m/Y", strtotime($marca['Marca']['data_cadastro']));?></td>
			    <td><?=$marca['User']['username'];?></td>
				<td>
				<?php
					if(array_key_exists($Usuario['perfil'], array_flip(array('Admin')))) {
						echo $this->Html->image('b_del.png',array('onClick' => '$().excluirMarca('.$marca['Marca']['id'].')'));
					} else {
						echo $this->Html->image('b_del_cinza.png',array('onClick' => 'alert("Operação negada para esse Perfil de Usuário!")'));
					}
				?>	
				</td>
				<td>
				<?php	
					if(array_key_exists($Usuario['perfil'], array_flip(array('Admin')))) {
						echo $this->Html->link($this->Html->image('b_edit.png', array('title'=>'Editar Marca')),array('action' => 'edit',$marca['Marca']['id']),array('escape'=>false));
					}else{
						echo $this->Html->image('b_edit_cinza.png',array('onClick' => 'alert("Operaçãoo negada para esse Perfil de Usuário!")'));	
					}
				?>
				</td>
			</tr>
		  	<?php } ?>
	  	
		</table>