
<?php 
	$categories = $this->getCategories(); //hämtar alla kategorier
	$count = 0;
	
	foreach($categories as $cat):
			if($count == 3){
				echo '<div style="padding:4px"></div>';
				$count = 0;
			}
	 echo CHtml::link('<span>'.$cat->category.'</span>', '/howto/category/'.$cat->category); 
	 $count = $count+1;
	 ?>
	
	<?php endforeach; ?>

