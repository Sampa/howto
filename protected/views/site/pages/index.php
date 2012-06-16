<?php $this->pageTitle=Yii::app()->name; 
$this->layout = "column1";
?>	

<div class="hero-unit span8" >
		<h1>Hello, knowledge!</h1>
		<p>
			At How-to.com we value knowledge, but not only that.
			We also focus on learning and understanding. 
			Create a how-to and share it with your intended readers.
			Save it as pdf for offline use at your company or 
			print it and put it up on the wall.<br/>
			Here you can find step-by-step Howto's for anything.
		</p>
		<p>
			<a class="btn btn-primary btn-large" href="/about">
				<i class="icon-white icon-book"></i> Why you should use How2 
				<i class="icon-white icon-arrow-right"></i>
			</a>
		</p>
   </div>

		<div class="span4 well" style="float:left;min-height:270px;"> <h2>Latest knowledge</h2>
				<?php 
					$models = Howto::model()->findAll(array('order' => 'create_time DESC','limit'=>5));
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
	  
    <div class="row-fluid" style="clear:both;padding: 0 0 0 15px;">
        <div class="span4">
        <h2>Creating</h2>
            <p>
			 Create Howto's easily thrue our user-friendly interface.
			 Easily add steps,images,references,while formatting the text with our powerfull text editor.<br/>
			 
			</p>
			<p>
				<a class="btn" href="/creating">
					Read more 
					<i class="icon-arrow-right"></i>
				</a>
			</p>
        </div>
		
    <div class="span4">
        <h2>Reading</h2>
        <p>
			Find Howto's by tags,category,rating or why not browse the most recently created knowledge.
			You can Bookmark,print and save the Howto as pdf. You can also comment and give feedback. 
		</p>		
		<p>
			<a class="btn" href="/reading">
			Read more
			<i class="icon-arrow-right"></i>
			</a>
		</p>
    </div>
	
    <div class="span4">
        <h2>Sharing</h2>
			<p>
				Mail the knowledge to a friend, share on facebook, twitter or google+. Save them to your computer and share with your collegues or family. Print and set up in your office.
			</p>
			<p>
				<a class="btn" href="/sharing">
					Read more
					<i class="icon-arrow-right"></i>
				</a>
			</p>
    </div>
    </div>
