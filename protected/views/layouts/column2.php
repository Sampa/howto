<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="span8" style="margin-left: 10px; margin-top: -18px; border:0px solid black;"> 
			<?php echo $content; ?>
</div>

		<div id="sidebar" class="span4" style="border:0px solid red;z-index:15;padding: 0px; position:relative; margin-top:-18px; margin-left:90px;">
		
<!-- siderbar clip--><?php echo $this->clips['sidebar']; ?>


<!-- tagcloud -->
			<div class="well" style=""> <h2>Popular tags</h2>
				<?php 
					$tags = Tag::model()->findTagWeights(20);

					foreach($tags as $tag=>$weight)
					{
						$link = CHtml::link( CHtml::encode( $tag ), array( 'tag/' . $tag ) );
						echo CHtml::tag('span', array(
							'class'=>'tag',
							'style'=>"font-size:{$weight}pt",
						), $link)."\n";
					}
				?>
				<div style="margin-top:15px;">
		<!-- tag search-->		
		<?php $this->widget('CAutoComplete', array(
			'model'=>new Howto,
			'id'=>'searchfield',
			'attribute'=>'tags',
			'url'=>array('/howto/suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>20, 'value'=>'Find Howto\'s by tag','style'=>'margin-top:-11px'),
		)); 
		?>
		
		<button class="btn btn-primary" style="margin-top: -20px;" id="searchbutton">
			<i class="icon-search icon-white"></i>
		</button>
		<script type="text/javascript">
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
		
			</div>

<!-- latest howto -->
			<div class="well" style="min-height:270px;"> <h2>Latest knowledge</h2>
				<?php 
					$models = Howto::model()->findAll(array('order' => 'create_time','limit'=>5));
					foreach ($models as $model):
					?>
			<div style="float:left;min-width:100%;margin-bottom:-20px;">		
			<?=CHtml::link(CHtml::encode($model->title), $model->url); ?>
					
					<!-- author link -->
	<div class="author">
		<div style="float:left;">
		Shared by	
		</div>
		<?php
			$this->widget('UserButton', 
				array(
				'id'=>$model->id,
				'userid'=>$model->author->id,
				'username'=>$model->author->username,
				'reputation'=>$model->author->reputation,
				)); 
		?>
<!-- created and last updated dates-->
		<div >
			<?php $created = date('F j, Y @ H:m',$model->create_time); ?> on <i> <?=$created;?></i> 
		</div>
	</div>
	</div>
		<?php endforeach;?>
			</div><!-- latest knowledge-->
		</div><!-- sidebar -->
<?php $this->endContent(); ?>