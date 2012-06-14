<div class=" span5">
           	<input id="searchbox" type="text" style="float:left;" class="" style="" 
			value="Type something to search for"  />

			<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
				'type' => 'primary',
				'toggle' => 'radio', // 'checkbox' or 'radio'
				'size'=>'small',
				'buttons' => array(
					array('label'=>'','icon'=>'book white',
					'htmlOptions'=>array('id'=>'howtos','title'=>'Search for Howtos')),
					array('label'=>'','icon'=>'user white',
					'htmlOptions'=>array('id'=>'users','title'=>'Search for Users')),
				),
			)); ?>
</div>
	<script type="text/javascript">
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
