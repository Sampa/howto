<div class="">
<ul id="pikame" class="jcarousel-skin-pika">
	<?php foreach ($panels as $panel):?>
	<li>
		<img src="/images/howto/<?=$howto;?>/slide/<?=$panel->picture;?>"/>
		<span><?=$panel->text;?></span>
	</li>

<?php endforeach;?>
	</ul>
<script>
$(document).ready(function(){
$("#pikame").PikaChoose({carousel:false});
});
</script>
</div>
