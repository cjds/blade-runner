<?php
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);

	$trans = $environment->getTranslator();
?>

<?php if ($paginator->getLastPage() > 1): ?>

	<ul class="pagination medium-2 medium-offset-5" style='margin:auto'>
		<?php
			$current=$paginator->getCurrentPage();
			$last=$paginator->getLastPage();
			//echo $presenter->getPrevious($trans->trans('pagination.previous'));

			//echo $presenter->getNext($trans->trans('pagination.next'));
		?>
		<?php if($current==1):?>
  			<li class="arrow unavailable"><a href="#">&laquo;</a></li>
  		<?php else:?>
  			<li class="arrow"><a href="<?php echo $paginator->getUrl(1)?>">&laquo;</a></li>
  		<?php endif;?>
  		<?php if($current>3):?>
  		<li class="unavailable"><a href="">&hellip;</a></li>
  		<?php endif;?>
			
		<?php for ($i=$current-3; $i < $current+3; $i++):
				if($i>0 && $i<=$last):?>
					<li  <?php echo ($i==$current)?'class="current"':''?>><a href="<?php echo $paginator->getUrl($i)?>"><?php echo $i?></a></li>		
		<?php endif;
		endfor;
		?>
		<?php if($last-$current>3):?>
  		<li class="unavailable"><a href="">&hellip;</a></li>
  		<?php endif;?>

  		<?php if($current==$last):?>
  			<li class="arrow unavailable"><a href="">&raquo;</a></li>
  		<?php else:?>
  			<li class="arrow"><a href="<?php echo $paginator->getUrl($last)?>">&raquo;</a></li>
  		<?php endif;?>
  
</ul>
	
	
	
<?php endif; ?>
