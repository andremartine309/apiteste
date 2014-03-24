<script>
	$(document).ready(function() {
		
		//Ativa as Tooltips
		$(function() {
		   $( document ).tooltip();
		});
	
	
		$.fn.extend ({
			//AJAX de Exclusão de Usuários
			excluirUsuario : function(id){
				//alert("id: " + id );
				//Remove a caixa de mensagens de erro, caso esteja sendo mostrada
				$( "#msgbox" ).slideUp( "slow", function() {
					$("#msgbox").hide();
					$("#msgbox").empty();
				});
				
				//Limpa os campos
				//$("#Id").val('');
		        
				
				var param = {"id" : id};
				
				if (confirm('Você deseja realmente excluir este Usuário?'))
				{	
		            //event.preventDefault();
			        $.ajax({
			            url: '/apiteste/Users/user_del/',
			            data: param,
			            type: 'POST',
			            success: function(data){
			            	
							if (data != ''){
				                //alert(data+'');
				                var IS_JSON = true;
								try
								{
									var obj = $.parseJSON(data);
								}
								catch(err)
								{
									IS_JSON = false;
								}
								
								if (IS_JSON)
								{
									//alert('Tipo: '+obj.tipo+' Msg: '+obj.msg);
									//alert(obj.msg);
									
									$( "#msgbox" ).slideDown( "slow", function() {
								    	//$("#msgbox").show();
								    	$( "#msgbox" ).append(obj.msg);
									});
									
									if (obj.tipo == 'ok')
									{
										$('#users_list').html(obj.list);
									}
								}
								else
								{
									//apenas para debug
									$( "#debug" ).append(data);
								}
				            }else{
				            	alert('Erro ao tentar excluir o Usuário: '+data);
				            }
			            }
			        });
			    }
			}//fim - AJAX de Exclusão de Usuários
		}); //fim - $.fn.extend
	}); //fim - $.(document).ready
		
</script>

<div id="debug">&nbsp;</div>

<div id="cabecalho-lista">
	<span id="titulo-lista">Usuários do Sistema</span>
	
	<span id="botao-novo">
		<?php
			if(array_key_exists($Usuario['perfil'], array_flip(array('Admin')))) {
				echo $this->Html->link('Novo','add') . '&nbsp;' . $this->Html->link($this->Html->image('btn_novo.gif'),array('action' => 'add'),array('escape'=>false));
			}else{
				echo 'Novo ' . $this->Html->image('btn_novo_cinza.gif',array('onClick' => 'alert("Operação negada para esse Perfil de usuário!")'));	
			}
		?>
	</span>
	
	<center>
		<div id="msgbox">&nbsp;</div>
	</center>
	
	<div id="users_list">
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
	</div>
</div>

<?=$this->element('paginacao');?>