
<?php $this->beginWidget('BootModal', array(
    'id'=>'dialogLogin',
    'htmlOptions'=>array('class'=>'hide','style'=>'width:auto;'),
    'events'=>array(
        'show'=>"js:function() { console.log('dialogLogin show.'); }",
        'shown'=>"js:function() { console.log('dialogLogin shown.'); }",
        'hide'=>"js:function() { console.log('dialogLogin hide.'); }",
        'hidden'=>"js:function() { console.log('dialogLogin hidden.'); }",
    ),
)); ?>

<div id="modal_login" class="divForForm" style="padding:25px;">

</div>
<?php $this->endWidget(); ?> 
<script type="text/javascript">
function getLogin(){
  <?php echo CHtml::ajax(array(
            'url'=>array('/site/login'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'render')
                {
                    $('#modal_login').html(data.div );
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogLogin div.divForForm form').submit(getLogin);
                }
                else
                {  /* $('#dialogLogin').modal('close') */
                    $('#dialogLogin div.succesDiv').html(data.div);
                }
 
            }",
            )); ?>
}

$("#loginButton").click(function(){
getLogin();
$('#dialogLogin').modal('show');
return false; 
});
</script>
<!-- end login -->
