
<?php 
	$categoryegories = $this->getCategories(); //hämtar alla kategorier
	$count = 0;
	
	foreach($categoryegories as $category):
			if($count == 3){
				echo '<div class="span-5"style="padding:4px"></div>';
				$count = 0;
			}
	 echo CHtml::link('<span>'.$category->name.'</span>', '/howto/category/'.$category->name); 
	 $count = $count+1;
	 ?>
	
	<?php endforeach; ?>

