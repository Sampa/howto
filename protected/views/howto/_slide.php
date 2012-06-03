	<ul id="pikame" class="jcarousel-skin-pika">
	<?php foreach ($panels as $panel):?>
	<li>
		<img src="/images/howto/<?=$howto;?>/slide/<?=$panel->picture;?>"/>
		<span><?=$panel->text;?></span>
	</li>

<?php endforeach;?>
	</ul>
	<script language="javascript">
			$(document).ready(
				function (){
					$("#pikame").PikaChoose({carousel:true});
				});
</script>

