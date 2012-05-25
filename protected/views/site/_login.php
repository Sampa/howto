
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

<div id="modal_login" class="divForForm well" style="padding:25px;">

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

	<script type="text/javascript">

jQuery(function($) {  
  var loggedIn = function(res) {

    if (res.returnURI) {
      window.location.assign(res.returnURI);
    } else {
      window.location.reload(true);
    }
  };
  var loggedOut = function(res) {
  };

  var gotAssertion = function(assertion) {
    // got an assertion, now send it up to the server for verification
    if (assertion) {
      $.ajax({
        type: 'POST',
        url: '/user/persona',
        data: { assertion: assertion },
        success: function(res, status, xhr) {
          if (res === null) {
            loggedOut();
          }
          else {
            loggedIn(res);
          }
        },
        error: function(res, status, xhr) {
          alert("Whoops, I failed to authenticate you! " + res.responseText);
        }
      });
    } else {
      loggedOut();
    }
  }

  $('#browserid').click(function() {
    navigator.id.get(gotAssertion, {allowPersistent: true});
    return false;
  });

  // Query persistent login.
  var login = $('head').attr('data-logged-in');
  if (login === "false") {
    navigator.id.get(gotAssertion, {silent: true});
  }
});
</script>
	<script type="text/javascript">
 $("#fb-login").click(function(){
 FB.login(function(response) {
   if (response.authResponse) {
     $("#conf").html('Welcome!  Fetching your information.... ');
     FB.api('/me', function(response) {
       $("#conf").append('Good to see you, ' + response.name + '.');
	  
	   window.location.replace('/user/addUser');
     });
   } else {
  /*   console.log('User cancelled login or did not fully authorize.');*/
   }
 });
 });
 </script>
