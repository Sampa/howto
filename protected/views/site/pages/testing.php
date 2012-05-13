	<script type="text/javascript" src="/js/jquery-easing-1.3.pack.js"></script>
	<script type="text/javascript" src="/js/jquery-easing-compatibility.1.2.pack.js"></script>
	<script type="text/javascript" src="/js/coda-slider.1.1.1.pack.js"></script>
	<script type="text/javascript">
	
		var theInt = null;
		var $crosslink, $navthumb;
		var curclicked = 0;
		
		theInterval = function(cur){
			clearInterval(theInt);
			
			if( typeof cur != 'undefined' )
				curclicked = cur;
			
			$crosslink.removeClass("active-thumb");
			$navthumb.eq(curclicked).parent().addClass("active-thumb");
				$(".stripNav ul li a").eq(curclicked).trigger('click');
			
			theInt = setInterval(function(){
				$crosslink.removeClass("active-thumb");
				$navthumb.eq(curclicked).parent().addClass("active-thumb");
				$(".stripNav ul li a").eq(curclicked).trigger('click');
				curclicked++;
				if( 6 == curclicked )
					curclicked = 0;
				
			}, 3000);
		};
		
		$(function(){
			
			$("#main-photo-slider").codaSlider();
			
			$navthumb = $(".nav-thumb");
			$crosslink = $(".cross-link");
			
			$navthumb
			.click(function() {
				var $this = $(this);
				theInterval($this.parent().attr('href').slice(1) - 1);
				return false;
			});
			
			theInterval();
		});
		</script>
<div class="slider-wrap">
	<div id="main-photo-slider" class="csw">
		<div class="panelContainer">
<?php 	$content ='';
		$howto = 1;
		$panels = Slide::model()->findAll('howto_id='.$howto);
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
		<a href="#2" class="cross-link">
<img src="/images/howto/<?=$howto;?>/slide/<?=$panel->picture;?>" class="nav-thumb" alt="temp-thumb" />		   </a>
		</div>
	</div>
<?php }} ?>
<div style="clear:both"></div>