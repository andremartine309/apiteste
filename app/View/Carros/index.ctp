<?php
	function calcParcelaJuros($valor,$parcelas,$juros=0){
	   if($juros==0){
	      return $valor;
	   }else{
	      $valor_total = 0;
	      for($i=1;$i<($parcelas+1);$i++){
	         $I =$juros/100.00;
	         $valor_parcela = $valor*$I*pow((1+$I),$parcelas)/(pow((1+$I),$parcelas)-1);
	         $valor_total+=$valor_parcela;
	      }
	      return number_format($valor_total,2);
	   }
	}
?>

<script>
	$(document).ready(function() {
		
		//Ativa as Tooltips
		$(function() {
		   $( document ).tooltip();
		});
	
	
		$.fn.extend ({
			//AJAX de Exclusão de Carros
			excluirCarro : function(id){
				//alert("id: " + id );
				//Remove a caixa de mensagens de erro, caso esteja sendo mostrada
				$( "#msgbox" ).slideUp( "slow", function() {
					$("#msgbox").hide();
					$("#msgbox").empty();
				});
				
				//Limpa os campos
				//$("#Id").val('');
		        
				
				var param = {"id" : id};
				
				if (confirm('Você deseja realmente excluir este Carro?'))
				{	
		            //event.preventDefault();
			        $.ajax({
			            url: '/apiteste/Carros/carro_del/',
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
										$('#carros_list').html(obj.list);
									}
								}
								else
								{
									//apenas para debug
									$( "#debug" ).append(data);
								}
				            }else{
				            	alert('Erro ao tentar excluir o Carro: '+data);
				            }
			            }
			        });
			    }
			}//fim - AJAX de Exclusão de Carros
		}); //fim - $.fn.extend
	}); //fim - $.(document).ready
		
</script>

<div id="debug">&nbsp;</div>

<div id="cabecalho-lista">
	<span id="titulo-lista">Carros</span>
	
	<span id="botao-novo">
		<?php
			if(array_key_exists($Usuario['perfil'], array_flip(array('Admin','Funcionário')))) {
				echo $this->Html->link('Novo','add') . '&nbsp;' . $this->Html->link($this->Html->image('btn_novo.gif'),array('title'=>'Incluir Carro','action' => 'add'),array('escape'=>false));
			}else{
				echo 'Novo ' . $this->Html->image('btn_novo_cinza.gif',array('title'=>'Incluir Carro'),array('onClick' => 'alert("Operação negada para esse Perfil de usuário!")'));	
			}
		?>
	</span>
	
	<center>
		<div id="msgbox">&nbsp;</div>
	</center>
	
	<div id="carros_list">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  		<tr>
			    <th>Id</th>
			    <th class="alinha-esquerda">Marca</th>
			    <th class="alinha-esquerda">Modelo</th>
			    <th>Ano</th>
			    <th>Data do Cadastro</th>
			    <th>Valor</th>
			    <th>Nº de Parcelas</th>
			    <th>Valor Total (c/ Juros)</th>
			    <th>Usuário Responsável</th>
			    <!--<th>Foto</th>-->
			    <th colspan="4">A&ccedil;&atilde;o</th>
	  		</tr>
  		
  		
	  		<?php foreach($Carros as $carro) { ?>
	  		<tr>
			    <td><?=$carro['Carro']['id'];?></td>
			    <td class="alinha-esquerda"><?=iconv("UTF-8","ISO-8859-1",$carro['Marca']['marca']);?></td>
			    <td class="alinha-esquerda"><?=iconv("UTF-8","ISO-8859-1",$carro['Carro']['modelo_carro']);?></td>
			    <td><?=$carro['Carro']['ano'];?></td>
			    <td><?=date("d/m/Y", strtotime($carro['Carro']['data_cadastro']));?></td>
			    <td>R$ <?=str_replace('.', ',', number_format($carro['Carro']['valor'],2));?></td>
			    <td><?=$carro['Carro']['nr_parcelas'];?></td>
			    <td>R$ <?=str_replace('.', ',', calcParcelaJuros($carro['Carro']['valor'],$carro['Carro']['nr_parcelas'],0.7));?></td>
			    <td><?=$carro['User']['username'];?></td>
			    <!--<td><img src="<?=$carro['Carro']['foto'];?>"></td>-->
				<td>
				<?php
					if(array_key_exists($Usuario['perfil'], array_flip(array('Admin')))) {
						echo $this->Html->image('b_del.png',array('title'=>'Excluir Carro','onClick' => '$().excluirCarro('.$carro['Carro']['id'].')'));
					} else {
						echo $this->Html->image('b_del_cinza.png',array('title'=>'Excluir Carro'),array('onClick' => 'alert("Operação negada para esse Perfil de Usuário!")'));
					}
				?>	
				</td>
				<td>
				<?php	
					if(array_key_exists($Usuario['perfil'], array_flip(array('Admin','Funcionário')))) {
						echo $this->Html->link($this->Html->image('b_edit.png', array('title'=>'Editar Carro')),array('action' => 'edit',$carro['Carro']['id']),array('escape'=>false));
					}else{
						echo $this->Html->image('b_edit_cinza.png',array('title'=>'Editar Carro'),array('onClick' => 'alert("Operação negada para esse Perfil de Usuário!")'));	
					}
				?>
				</td>
				<td>
				<?php	
					if(array_key_exists($Usuario['perfil'], array_flip(array('Admin','Funcionário')))) {
						echo $this->Html->link($this->Html->image('photography.png', array('title'=>'Administrar Fotos do Carro')),array('action' => '../Fotos/add',$carro['Carro']['id']),array('escape'=>false));
					}else{
						echo $this->Html->image('photography_cinza.png',array('title'=>'Administrar Fotos do Carro'),array('onClick' => 'alert("Operação negada para esse Perfil de Usuário!")'));	
					}
				?>
				</td>	
				<td>
				<?php	
					echo $this->Html->link($this->Html->image('icon_lupa.gif', array('title'=>'Visualizar Carro')),array('action' => 'view',$carro['Carro']['id']),array('escape'=>false));
				?>
				</td>
			</tr>
		  	<?php } ?>
	  	
		</table>
	</div>
</div>

<?=$this->element('paginacao');?>