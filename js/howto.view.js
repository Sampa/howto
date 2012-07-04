	function initThis(){


	 $('.savebutton').click(function(){
	 var id = $(this).attr('name');
	});
	 

			$(".bookmark").click(function(){
		id = $(this).attr('name');
		url = '/howto/bookmark';
		jQuery.getJSON(url, {id: id}, function(data) {
			if (data.status == 'success'){
					$('#bookmark_success_'+id).html(data.div);
					$('#bookmark_success_'+id).fadeIn('slow');			
					var pause = setTimeout("$('#bookmark_success_'+id).fadeOut('slow')",5000);
					
				}
			if(data.status =='failure'){
					$('#bookmark_success_'+id).html(data.div);
					$('#bookmark_success_'+id).fadeIn('slow');			
					var pause = setTimeout("$('#bookmark_success_'+id).fadeOut('slow')",5000);
			}
			});
			return false;
		});
	$(".edit_area").click(function(){
		var id = $(this).attr('name');
	var dataid = id;
	if(nicEditors.findEditor('edit_content'+id) == undefined){ 
	var myNicEditor = new nicEditor({uploadURI:'/nic/upload.php?hej='+dataid});
	myNicEditor.setPanel('nic'+dataid);
	myNicEditor.addInstance('edit_content'+dataid);
	}
			$("button[rel="+id+"]").fadeIn('slow');
			$("#nic"+id).fadeIn('slow');
		});
	
	$(".savecontent").click(function(){
	 		var id = $(this).attr('rel');
			 var content = $("div[name="+id+"]").html();
					url = '/howto/updatecontent';
					$.ajax({
					 type:"POST",
					  url: url,
					  dataType: 'json',
					  data: {content:content,id:id},
					  success: function(data) {
					if (data.status == 'success') {
						$("button[rel="+id+"]").fadeOut('slow');
						console.log(data.div);
						$("#nic"+id).fadeOut('slow')
						$('#save_content_response'+id).html(data.div);	
						$('#save_content_response'+id).fadeIn('slow');	
						var foo = $('#save_content_response'+id);
						var pause = setTimeout("$('#save_content_response"+id+"').fadeOut('slow')",5000);
					  return true;	
						
					}}
					});
		});

			$(".howtodelete").click(function(){
				var id = $(this).attr('name');
				deletehowto(id);
			});

		function deletehowto( id ) {
			url = '/howto/delete';
			jQuery.getJSON(url, {id: id}, function(data) {
				if (data.status == 'success')
					{
						$('#delete_howto_message'+id).html(data.div);
						$('#delete_howto_message'+id).fadeIn('slow');			

					} 
				});
				return false;
			}
	}