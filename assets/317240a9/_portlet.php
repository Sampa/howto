<?php if($data->active ==1):?>
<li id="<?=$data->id;?>" class="portlet-li">
	<div href="#" class="thumbnail well" rel="tooltip" data-title="Tooltip">
      <div class="portlettitlediv" > 
			<?="#".$data->id."&nbsp;";?>
			<span  name="portlettitle<?=$data->id;?>"><?=$data->title;?></span>
		</div>
			<a href="#" class="maximize"><i class="icon-resize-full"  title="Maximize"></i></a>
			<a href="#" class="toggle"><i class="icon-resize-small"  title="Minimize"></i></a>
			<a href="#" class="hideportlet"><i class="icon-eye-close"  title="Deactivate"></i></a>
			<a href="#" class="delete_portlet" name="<?=$data->id;?>"><i class="icon-ban-circle"  title="Delete"></i></a>
			
		<div class="portletcontent" name="<?=$data->id;?>">
			<div class="contentwrapper"><?=$data->content;?></div>
			
			<?php
					if($data->render !== "" && file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.''.$data->render.'.php')){  
						$render = $this->renderPartial($data->render,array('renderProperties'=>$renderProperties ),true);
					}else{
						$render = false;
					}
						echo '<span style="display:none;" id="render'.$data->id.'">'.$data->render.'</span>';
						echo '<div class="portletrender" name="portletrender'.$data->id.'">';
						echo ($render) ?  $render : null;
						echo '</div>';   
				 
			?>
		</div>
	</div>
</li>
<?php endif;?>
