	<div style="float:left; margin-top:-8px;">
			<ul class="nav nav-pills">
				<li class="dropdown" >
					<a class="dropdown-toggle" data-toggle="dropdown" href="#sidebarmenu<?=$id;?>">
						<?= $username;?>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?= User::getUserUrl($username);?>">View Profile</a></li>
						<li><a href="/message/compose?id=<?=$userid;?>">Send message</a></li>
						<li><a href="/howto/show/by?user=<?=$username;?>">More by <?=$username;?></a></li>
						<li>
							<?php
								if ( Yii::app()->user->id !== $id )
								{
									echo '<div id="req_res">';

									echo CHtml::ajaxLink(
										'<i class="icon-white icon-plus"></i>'.
										$reputation,          // the link body (it will NOT be HTML-encoded.)
										array('user/reputation/id/'.$userid), 
										// the URL for the AJAX request. If empty, it is assumed to be the current URL.
										array(
											'update'=>'#req_res',
										),
										array('class'=>'btn btn-success')
									);
									echo '</div>';
								}
							?>
						</li>
					</ul>
				</li>
			</ul>
		</div>