$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist11", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 		= parentObj.find('.submit_checklist11').attr('data-id');
		var var11 	= parentObj.find('input[name="var11"]').val();
                var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var11
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});

$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist12", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 		= parentObj.find('.submit_checklist12').attr('data-id');
		var var12 	= parentObj.find('input[name="var12"]').val();
		var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var12
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});



$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist14", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 			= parentObj.find('.submit_checklist14').attr('data-id');
		var var14 		= parentObj.find('input[name="var14"]').val();
		var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var14
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});

$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist16", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 			= parentObj.find('.submit_checklist16').attr('data-id');
		var var16 		= parentObj.find('input[name="var16"]').val();
		var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var16
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});

$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist18", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 			= parentObj.find('.submit_checklist18').attr('data-id');
		var var18 		= parentObj.find('input[name="var18"]').val();
		var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var18
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});

$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist20", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 			= parentObj.find('.submit_checklist20').attr('data-id');
		var var20 		= parentObj.find('input[name="var20"]').val();
		var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var20
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});

$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist22", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 			= parentObj.find('.submit_checklist22').attr('data-id');
		var var22 		= parentObj.find('input[name="var22"]').val();
		var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var22
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});

$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist23", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 			= parentObj.find('.submit_checklist23').attr('data-id');
		var var23 		= parentObj.find('input[name="var23"]').val();
		var proceed = true;
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var23
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});

$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist11_1", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 		= parentObj.find('.submit_checklist11_1').attr('data-id');
		var var11_1 	= parentObj.find('input[name="var11_1"]:checked').val();
                var cl_1        = parentObj.find('input[name="cl_1"]').val();
		var ph_1   	= parentObj.find('input[name="ph_1"]').val();
		var proceed = true;
                
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var11_1,cl_1,ph_1
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});
$(document).ready(function(){
	$(".form_in_me_fas").on("click", ".submit_checklist23_2", function(){ 
		//$(this).find
		var parentObj	= $(this).closest('.item-sub');
		var id 		= parentObj.find('.submit_checklist23_2').attr('data-id');
		var var23_2 	= parentObj.find('input[name="var23_2"]:checked').val();
                var cl_2        = parentObj.find('input[name="cl_2"]').val();
		var ph_2   	= parentObj.find('input[name="ph_2"]').val();
		var proceed = true;
                
		if(proceed){
			//get input field values data to be sent to server
			post_data = {
				id,var23_2,cl_2,ph_2
			};

			//Ajax post data to server
			$.post('action/insert_checklist_me_fas.php', post_data, function(response){ 
				//console.log('dor');
				if(response.type == 'error'){ 
					output = '<div class="error">'+response.text+'</div>';
					console.log ('error');
				}else{
					output = response.text;
				}
				parentObj.find(".success-status").hide().html(output).slideDown();
			}, 'json');
		}
	});
});
