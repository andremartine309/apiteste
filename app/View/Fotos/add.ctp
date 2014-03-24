<?php //var_dump($Carro);exit; ?>
<script>
	$(document).ready(function() {
		
		//Ativa as Tooltips
		$(function() {
		   $( document ).tooltip();
		});
		
		//AJAX de Inclusão de Anexos
	    $(':file').change(function(){
			var file = $("#anexosArquivo");//this.files[0];
		    name = file.name;
		    size = file.size;
		    type = file.type;
		    //Your validation
		});
		
		$("#btn_foto_incluir").click(function(event) {
			//Remove a caixa de mensagens de erro, caso esteja sendo mostrada
			$( "#msgbox" ).slideUp( "slow", function() {
				$("#msgbox").hide();
				$("#msgbox").empty();
			});
			
			var formData = new FormData($('form')[0]);
		    $.ajax({
		        url: '/apiteste/Fotos/foto_add/',
		        type: 'POST',
		        xhr: function() {  // Custom XMLHttpRequest
		            var myXhr = $.ajaxSettings.xhr();
		            if(myXhr.upload){
		                myXhr.upload.addEventListener('progress',
		                function progressHandlingFunction(e){
						    if(e.lengthComputable){
						        $('progress').attr({value:e.loaded,max:e.total});
						    }
						}, 
		                false); 
		            }
		            return myXhr;
		        },
		        //Ajax events
		        beforeSend: function(xhr, opts){
		        	
		        	if ($('#arquivo').val() == '')
		        	{
		        		alert("Você deve selecionar um arquivo para efetuar o upload!");
		        		xhr.abort();
		        	}
		        	else
		        	{
		        		//alert(formData);
		        		$('progress').show();
		        	}
		        	//alert('Antes: '+formData)
		        },
		        success: function(data){
			        //alert('Sucesso: '+data);
			        $('progress').hide();
			        $('#fotos_list').html(data);
			    },
		        error: function(data){
		        	//alert(data);
		        	
		        	var out = '';
				    for (var i in data) {
				        out += i + ": " + data[i] + "\n";
				    }
				    
				    $( "#debug" ).append(out);
			    },
		        // Form data
		        data: formData,
		        //Options to tell jQuery not to process data or worry about content-type.
		        cache: false,
		        contentType: false,
		        processData: false
		    });
	    }); //fim - AJAX de Inclusão de Fotos
	
		$.fn.extend ({
			//AJAX de Exclusão de Fotos
			excluirFoto : function(id,carros_id){
				//alert("id: " + id );
				//Remove a caixa de mensagens de erro, caso esteja sendo mostrada
				$( "#msgbox" ).slideUp( "slow", function() {
					$("#msgbox").hide();
					$("#msgbox").empty();
				});
				
				//Limpa os campos
				//$("#Id").val('');
		        
				
				var param = {"id" : id, "carros_id" : carros_id};
				
				if (confirm('Você deseja realmente excluir esta Foto?'))
				{	
		            //event.preventDefault();
			        $.ajax({
			            url: '/apiteste/Fotos/foto_del/',
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
										$('#fotos_list').html(obj.list);
									}
								}
								else
								{
									//apenas para debug
									$( "#debug" ).append(data);
								}
				            }else{
				            	alert('Erro ao tentar excluir a Foto: '+data);
				            }
			            }
			        });
			    }
			}//fim - AJAX de Exclusão de Fotos
		}); //fim - $.fn.extend
	}); //fim - $.(document).ready
</script>

<div id="debug">&nbsp;</div>

<div id="area-form">
	<?=$this->Form->create('Foto'); ?>
	<?=$this->Form->input('Carro.id',array('id'=>'Carro.id','label'=>false,'type'=>'hidden','value'=>$Carro['Carro']['id']));?>
	<?=$this->Form->input('Usuario.id',array('id'=>'Usuario.id','label'=>false,'type'=>'hidden','value'=>$Usuario['id']));?>
	
	<div id="cabecalho-lista">
		<span id="titulo-lista">Inclusão de Fotos</span>
	</div>
	
	<table id="fotos_edit" border="0" cellpadding="0" cellspacing="0" align="center" width="90%">
		<tbody>
        <tr>			
		  <td align="right">Arquivo </td>
	      <td><?=$this->Form->file('arquivo',array('label'=>false,'size'=>50,'maxlength'=>250,'type'=>'file'));?> </td>
        </tr>
        </tbody>
	</table>
	
	<br /><center><progress max="100" class="progress_bar"></progress></center><br />
	
	<div id="botao" align="center">
		<?=$this->Form->button('Incluir Foto',array('id'=>'btn_foto_incluir','type'=>'button','class'=>'botao_ajax'));?>
	</div><br />
	<?=$this->Form->end(); ?>
	
	<div id="lista-dados">
		<div id="fotos_list">
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
		</div>
	</div>
</div>
