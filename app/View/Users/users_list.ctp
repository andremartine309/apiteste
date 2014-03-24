<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	    <th>Id</th>
	    <th class="alinha-esquerda">Username</th>
	    <th>Perfil</th>
	    <th colspan="5">A&ccedil;&atilde;o</th>
	</tr>


	<?php foreach($Users as $user) { ?>
	<tr>
	    <td><?=$user['User']['id'];?></td>
	    <td class="alinha-esquerda"><?=iconv("UTF-8","ISO-8859-1",$user['User']['username']);?></td>
	    <td><?=iconv("UTF-8","ISO-8859-1",$user['Perfil']['nome_perfil']);?></td>
		<td>
		<?php
			if(array_key_exists($Usuario['perfil'], array_flip(array('Admin'))) && $user['User']['id'] != $Usuario['id']) {
				echo $this->Html->image('b_del.png',array('onClick' => '$().excluirUsuario('.$user['User']['id'].')'));
			} else {
				echo $this->Html->image('b_del_cinza.png',array('onClick' => 'alert("Operação negada para esse Perfil de Usuário!")'));
			}
		?>	
		</td>
	</tr>
  	<?php } ?>

</table>