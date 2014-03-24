<script>
	$(document).ready(function() {
		
		//Ativa as Tooltips
		$(function() {
		   $( document ).tooltip();
		});
	
	
		$.fn.extend ({
			//AJAX de Exclusão de Marcas
			excluirMarca : function(id){
				//alert("id: " + id );
				//Remove a caixa de mensagens de erro, caso esteja sendo mostrada
				$( "#msgbox" ).slideUp( "slow", function() {
					$("#msgbox").hide();
					$("#msgbox").empty();
				});
				
				//Limpa os campos
				//$("#Id").val('');
		        
				
				var param = {"id" : id};
				
				if (confirm('Você deseja realmente excluir esta Marca?'))
				{	
		            //event.preventDefault();
			        $.ajax({
			            url: '/apiteste/Marcas/marca_del/',
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
										$('#marcas_list').html(obj.list);
									}
								}
								else
								{
									//apenas para debug
									$( "#debug" ).append(data);
								}
				            }else{
				            	alert('Erro ao tentar excluir a Marca: '+data);
				            }
			            }
			        });
			    }
			}//fim - AJAX de Exclusão de Marcas
		}); //fim - $.fn.extend
	}); //fim - $.(document).ready
		
</script>

<div id="debug">&nbsp;</div>

<div id="cabecalho-lista">
	<span id="titulo-lista">Marcas</span>
	
	<span id="botao-novo">
		<?php
			if(array_key_exists($Usuario['perfil'], array_flip(array('Admin','Funcionário')))) {
				echo $this->Html->link('Novo','add') . '&nbsp;' . $this->Html->link($this->Html->image('btn_novo.gif'),array('action' => 'add'),array('escape'=>false));
			}else{
				echo 'Novo ' . $this->Html->image('btn_novo_cinza.gif',array('onClick' => 'alert("Operação negada para esse Perfil de usuário!")'));	
			}
		?>
	</span>
	
	<center>
		<div id="msgbox">&nbsp;</div>
	</center>
	
	<div id="marcas_list">
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
					if(array_key_exists($Usuario['perfil'], array_flip(array('Admin','Funcionário')))) {
						echo $this->Html->link($this->Html->image('b_edit.png', array('title'=>'Editar Marca')),array('action' => 'edit',$marca['Marca']['id']),array('escape'=>false));
					}else{
						echo $this->Html->image('b_edit_cinza.png',array('onClick' => 'alert("Operaçãoo negada para esse Perfil de Usuário!")'));	
					}
				?>
				</td>
			</tr>
		  	<?php } ?>
	  	
		</table>
	</div>
</div>

<?=$this->element('paginacao');?>