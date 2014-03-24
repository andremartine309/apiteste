<div id="debug">&nbsp;</div>

<div id="cabecalho-lista">
	<span id="titulo-lista">Logs de Acesso ao Sistema</span>
	
	<center>
		<div id="msgbox">&nbsp;</div>
	</center>
	
	<div id="logs_list">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  		<tr>
			    <th>Id</th>
			    <th>Data do Acesso</th>
			    <th>Usuário</th>
	  		</tr>
  		
  		
	  		<?php foreach($Logs as $log) { ?>
	  		<tr>
			    <td><?=$log['Log']['id'];?></td>
			    <td><?=date("d/m/Y H:i", strtotime($log['Log']['data_log']));?></td>
			    <td><?=$log['User']['username'];?></td>
				<td>
			</tr>
		  	<?php } ?>
	  	
		</table>
	</div>
</div>

<?=$this->element('paginacao');?>