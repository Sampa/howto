<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="span8" style="margin-left: 10px; margin-top: -18px; border:0px solid black;"> 
			<?php echo $content; ?>
</div>

		<div id="sidebar" class="span5 well" style="border:0px solid red;z-index:15;padding-left:15px; position:relative; margin-top:-9px; margin-left:40px;">
		
<!-- siderbar clip--><?php echo $this->clips['sidebar']; ?>


<!-- tagcloud -->

		<h2>Popular tags</h2>
				<?php 
					$tags = Tag::model()->findAll(array('limit'=>15,'order'=>'frequency'));
					$foo ="";
					foreach($tags as $tag)
					{
						$weight = $tag->frequency +100;

						$foo .='{text:"'.$tag->name.'", weight: '.$weight.', link: "/tag/'.$tag->name.'"},';

					}
				?>
    <script type="text/javascript">
      /*!
       * Create an array of word objects, each representing a word in the cloud
       */
      var word_array = [
         <?=$foo;?>
          // ...as many words as you want
      ];


    </script>

    <!-- You should explicitly specify the dimensions of the container element -->
    <div id="example" style="width: 350px;background:url(/images/cloud.gif) no-repeat; height: 250px;"></div>
    <!-- You should explicitly specify the dimensions of the container element -->
	
		<div style="margin-top:15px;">
		<!-- tag search-->		
		
		
		
		<script type="text/javascript">
		        $("#example").jQCloud(word_array);

			$("#searchfield").focus(function(){
				$(this).val('');
			});
			$("#searchbutton").click(function(){
				var val = $("#searchfield").val();
				if(val === 'Find Howto\'s by tag' || val===''){
				alert('Perhaps you should search something real instead ;\)');
				}else{
				val = val.replace(",",'');
				var url = "/tag/"+val; 
				$(location).attr('href',"/tag/"+val);
				}
			})
		</script>
		</div>

<!-- latest howto -->
	<?php $this->widget('LatestKnowledge');?>

		</div><!-- sidebar -->
<?php $this->endContent(); ?>