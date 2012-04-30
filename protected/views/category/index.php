	<?php
		$this->breadcrumbs=array(
			'Categories',
		);
	?>
<?php foreach( $parents as $parent ):?>
<div class="well" style="height:95px;max-width:40%;float:left;margin-right:4%;">
	<div style="float:left;">
		<h2><?=CHtml::link($parent->name,array("howto/category/".$parent->name));?></h2>
	</div>
	<div style="float:left;">
	<?php
		$categories = Category::model()->findAll(array(
					'order'=>'name', 
					'condition'=>'parent=:parent', 
					'params'=>array(':parent'=>$parent->name)
					));
		$count = 1;
		foreach( $categories as $category )
		{
		echo "<span style=''>".CHtml::link($category->name.' ',
		array("howto/category/".$category->name))."</span>";
		
		if( count($categories) !== $count )
			echo '<span style="color:#0000ff">- </span>';
		$count++;
		}
		
	?>
	</div>
</div>

<?php endforeach;?>

<div id="container" style="margin-top: 30px; padding-left: 20px"> 

</div>