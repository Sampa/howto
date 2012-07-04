<?php
$this->breadcrumbs=array(
	$model->name,
);

?>
<h1><?php echo $model->name; ?></h1>
<?php foreach($model->howtos as $howto){
if($howto->author == Yii::app()->user->id){
$owner = true;}else{$owner = false;}
	$this->renderPartial('/howto/_view',array('data'=>$howto,'owner'=>$owner ) ); 
}?>
