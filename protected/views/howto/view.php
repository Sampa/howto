<?php
	$this->breadcrumbs = array( $model->title, );
	$this->pageTitle = $model->title;
	$this->layout = "column1";
?>
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
			
			$navthumb.click(function() {
				var $this = $(this);
				theInterval($this.parent().attr('href').slice(1) - 1);
				return false;
			});
			
			theInterval();
		});
	</script>
<div id="howto_container" style="padding-left: 0px; float:left;">
	<div id="left" class="span7" style="float:left;" >
<?php 
	$this->renderPartial('_view',
	array(
		'data'=>$model,
	) ); 
?>
<?php // social plugin
	$this->widget('application.extensions.social.social', 
		array(
			'style'=>'horizontal', 
			'networks' => array(
				'twitter'=>array(
					'data-via'=>'', //http ://twitter.com/#!/YourPageAccount if exists else leave empty
					), 
				'googleplusone'=>array(
					'size'=>'medium',
					'annotation'=>'bubble',
				), 
				'facebook'=>array(
					'href'=>'https://www.facebook.com/your_facebook_page',//asociate your page http://www.facebook.com/page 
					'action'=>'recommend',//recommend, like
					'colorscheme'=>'light',
					'width'=>'130px',
					)
				)
			)
		);
?> 	 	</div><!--left-->
	
	<!-- steps-->
	<div id="steps" class="span8" style="clear:both; float:left;">
		<?php if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?= $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3>
		<?php endif; ?>
		<?php
		foreach ( $model->steps as $step ):
			echo CHtml::link( $step->title, array('/step/update?id=' . $step->id .'&howtoid=' . $model->id ) );
			echo '<br/><div class="well edit_step" ">' . $step->text .'</div>';
		 endforeach; 
		 ?>
	
	</div>

</div><!-- container-->
	<div id="comments" style="margin-top: 30px" class="span3" >
<?php
	
	$panels = Slide::model()->findAll('howto_id='.$model->id);
	if ( $panels )
	{
		$this->renderPartial('_slide',array('howto'=>$model->id,'panels'=>$panels));
	}
	if ( $owner )
	{
		echo "<br/>".CHtml::button("Manage Slides",array('class'=>'btn btn-primary manage_slide'));
		$this->registerAssets();	
		$slide = new Slide('search');
		echo $this->renderPartial('//slide/index' , array( 'model'=>$slide,'howto'=>$model->id ) );
	}
	
	
	?>
	<script type="text/javascript">
	$(document).ready(function(){
	});
		$(".manage_slide").click(function(){
			$("#slide_div").toggle();
		});
	</script>
<div id="disqus_thread" style="clear:both;"></div>
	</div><!-- comments -->
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'howtos'; // required: replace example with your forum shortname
/*	var disqus_url = $data->url;*/

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
	
</script>