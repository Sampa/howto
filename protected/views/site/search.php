<div class=" span5" style="margin-left:40px;">
<style type="text/css">
#jquery-live-search {
	background: #fff;
	
	padding: 5px 10px;
	max-height:800px;
	overflow: hidden;
	position: absolute;
	z-index: 99;

	border: 1px solid #A9A9A9;
	border-width: 0 1px 1px 1px;

	-webkit-box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);
	-moz-box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);
	box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);
}</style><i class="icon-search" style="float:left; position:relative;top:7px;"></i>


			<form method="post">
           	<input id="searchbox" class="tagbox" type="text" name="q" style="float:left;width:260px;"
			value="Type something to search for"  />
			</form>
			<?php
			/* $this->widget('bootstrap.widgets.BootButtonGroup', array(
				'type' => 'primary',
				'toggle' => 'radio', // 'checkbox' or 'radio'
				'size'=>'small',
				'buttons' => array(
					array('label'=>'','icon'=>'book white',
					'htmlOptions'=>array('id'=>'howtos','title'=>'Search for Howtos')),
					array('label'=>'','icon'=>'user white',
					'htmlOptions'=>array('id'=>'users','title'=>'Search for Users')),
				),
			)); */
			?>
</div>
	<script type="text/javascript">
	
	jQuery('#searchbox').liveSearch({url:'/howto/search?find='});
	$("#options").click(function(){
		$("#search_options").fadeIn('slow');
		
	});
	$("#searchbox").click(function(){
		$("#searchbox").val('');
	});
	$("#howtos").click(function(){
			var search_string = $("#searchbox").val();

			url = '/howto/search/find/'+search_string;
			window.location.replace(url);
	});
	$("#users").click(function(){
			var search_string = $("#searchbox").val();

			url = '/user/search/find/'+search_string;
			window.location.replace(url);
	});

	</script>
