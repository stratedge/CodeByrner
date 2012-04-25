<? $this->load->view('header'); ?>

<?  if(!isset($main)) $main = array(); ?>

<div class="row">
	<div class="twelvecol last">
		<? foreach($main as $content) echo $content; ?>
	</div>
</div>

<? $this->load->view('footer'); ?>