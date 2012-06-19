
<div style="float:left; margin-top:-8px; padding:0px 3px 0px 3px;">					
	<ul class="nav nav-pills">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html">
			Admin
			<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<?php if($profileLink):?>
				<li><a href="<?=User::getUserUrl($username);?>">View Profile</a></li>
				<?php endif;?>
				<li><a href="/message/compose?id=<?=$userid;?>">Send Message</a></li>
				<li><a href="/howto/show/by/user/<?=$username;?>">Howtos by <?=$username;?></a></li>

			</ul>
		</li>
    </ul>
</div>