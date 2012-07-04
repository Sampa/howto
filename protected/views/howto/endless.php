<?php  Yii::app()->clientScript->registerScriptFile('/js/howto.view.js',CClientScript::POS_BEGIN);?>

<?php if(!empty($_GET['tag'])): ?>
<h1>Howto's Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>
<?php if(!empty($_GET['category'])): ?>
<h1>Howto's in  <i><?php echo CHtml::encode($_GET['category']); ?></i></h1>
<?php endif; ?>
<div  style="float:left;">


<?php 
$itemView = "_view";
if(isset($search)){
$itemView = "_ajaxSearch";
$this->widget('BootListView', array(
	'dataProvider'=>$userProvider,
	'itemView'=>'_userview',
	'template'=>"{items}",
)); 
}
if(Yii::app()->request->isAjaxRequest) 
		$this->layout = "ajax";

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/howto/'.$itemView,
	'template'=>"{items}<div style=''>{pager}</div>",
	'afterAjaxUpdate'=>'js:function () {
     $("[id^=rating]").each(function () {
       $(this).find("input").rating();
     }); initThis();
    }',


));
?>
<script>

	$(document).ready(function(){
		initThis();
	});
</script>
</div>


