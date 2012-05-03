<?php 
	$this->beginWidget('bootstrap.widgets.BootModal', 
	array(
    'id'=>'dialogMail',
    'htmlOptions'=>array('class'=>'hide'),
		'events'=>array(
			'show'=>"js:function() { console.log('dialogMail show.'); }",
			'shown'=>"js:function() { console.log('dialogMail shown.'); }",
			'hide'=>"js:function() { console.log('dialogMail hide.'); }",
			'hidden'=>"js:function() { console.log('dialogMail hidden.'); }",
		),
	)); 
?>
	<div id="modal_mail" class="divForForm"></div>
<?php $this->endWidget(); ?> 
	
	<script type="text/javascript">
	function getMail(url){
	jQuery.ajax({'url':'/howto/mail'+url, 'data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
	{
	if (data.status == 'render')
	{
	$('#modal_mail').html(data.div );
	// Here is the trick: on submit-> once again this function!
	$('#dialogMail div.divForForm form').submit(getMail);
	}
	else
	{ /* $('#dialogMail').modal('close') */
	$('#dialogMail div.succesDiv').html(data.div);
	}
	},'cache':false});} 
	$(".mail").click(function(){
	url = $(this).attr('name');
	getMail(url);
	$('#dialogMail').modal('show');
	return false; 
	});
	</script>
<!-- end Mail -->
