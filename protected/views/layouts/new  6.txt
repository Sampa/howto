
<div class="slider-wrap">
	<div id="main-photo-slider" class="csw">
		<div class="panelContainer">
<?php 	$content ='';
		foreach ($panels as $panel):?>
			<div class="panel" title="<?=$panel->title;?>">
				<div class="wrapper">
						<img src="/images/howto/<?=$howto;?>/slide/<?=$panel->picture;?>" alt="temp" />
						<div class="photo-meta-data">
						<?=$panel->text;?>
						</div>
				</div>
			</div>
<?php endforeach;?>
		</div>
	</div>
<?php
$loop = 0;
foreach ($panels as $panel)
{
	$loop = $loop +1;
	if( $loop == 1 ){?>
	<a href="#1" class="cross-link active-thumb">
<img src="/images/howto/<?=$howto;?>/slide/<?=$panel->picture;?>" class="nav-thumb" alt="temp-thumb"/>
	</a>
	<?php  
	}else{
	?>
	<div id="movers-row">
		<div>
		<a href="#<?=$loop;?>" class="cross-link">
<img src="/images/howto/<?=$howto;?>/slide/<?=$panel->picture;?>" class="nav-thumb" alt="temp-thumb" />		   </a>
		</div>
	</div>
<?php }} ?>
<div style="clear:both"></div>