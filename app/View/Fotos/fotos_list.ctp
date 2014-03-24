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
							echo $this->Html->image('b_del.png',array('title'=>'Excluir Foto','onClick' => '$().excluirFoto('.$foto['Foto']['id'].','.$foto['Foto']['carros_id'].')'));
						} else {
							echo $this->Html->image('b_del_cinza.png',array('title'=>'Excluir Foto'),array('onClick' => 'alert("Operação negada para esse Perfil de Usuário!")'));
						}
					?>	
					</td>
					</tr>
				 <?php } ?>
			</table>