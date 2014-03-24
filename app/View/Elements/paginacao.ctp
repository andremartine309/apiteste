<?php if($this->Paginator->hasNext() || $this->Paginator->hasPrev()){ ?>
<center>
<div id="paginacao">
	<div>
		Mostrando p&aacute;gina: <?php echo $this->Paginator->counter(array("separator"=>" de ")); ?></div>
	<div>
	<div>
		
		<?php echo $this->Paginator->prev("Anterior"); ?>
		<?php echo $this->Paginator->numbers(); ?>
		<?php echo $this->Paginator->next("Próxima"); ?>
	</div>
</div>
<?php } ?>
