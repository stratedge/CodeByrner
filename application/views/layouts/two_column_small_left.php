<? 
	if(!isset($left)) $left = array();
	if(!isset($right)) $right = array();
?>

<? $this->load->view('header'); ?>

<div class="row">
	<div class="threecol">
		<? foreach($left as $content) echo $content; ?>
	</div>
	<div class="ninecol last">
		<? foreach($right as $content) echo $content; ?>
	</div>
</div>

<? $this->load->view('footer'); ?>