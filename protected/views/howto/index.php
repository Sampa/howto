<?php  Yii::app()->clientScript->registerScriptFile('/js/howto.view.js',CClientScript::POS_BEGIN);?>

<?php if(!empty($_GET['tag'])): ?>
<h1>Howto's Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>
<?php if(!empty($_GET['category'])): ?>
<h1>Howto's in  <i><?php echo CHtml::encode($_GET['category']); ?></i></h1>
<?php endif; ?>
<div  style="float:left;" class="span7" id="howto_index">

<?php 
	$itemView = "_view";
	if ( isset ( $search ) )
	{
		$this->layout = "ajax";
		$itemView = "_ajaxSearch";
		$this->widget('BootListView', array(
			'dataProvider'=>$userProvider,
			'itemView'=>'_userview',
			'template'=>"{items}",
		)); 
	}
	$this->widget('zii.widgets.CListView', array(
		'id'=>'hlist',
		'dataProvider'=>$dataProvider,
		'itemView'=>'/howto/'.$itemView,
		'template'=>"{items}{pager}",
		'pager' => array(
                    'class' => 'ext.infiniteScroll.IasPager', 
                    'rowSelector'=>'.howtopage', 
                    'listViewId' => 'hlist', 
                    'header' => '',
					'options'=>array(
					'onRenderComplete'=>'js:function () {
					 $("[id^=rating]").each(function () {
					   $(this).find("input").rating();
					 }); initThis();
						}'
					),
                  ),
	));
	if ( ! isset( $search ) ):
	?>
	<script>/*
	''id'=>'list-identifier',
			'pager'=>array(
				'class'=>'ext.yiinfinite-scroll.YiinfiniteScroller',
				'contentSelector' => '#howto_index',
				'itemSelector' => 'div.howtopage',
			)*/
			
		$(document).ready(function(){
			initThis();
			
		});
	</script>
	<?php endif;?>
</div>


