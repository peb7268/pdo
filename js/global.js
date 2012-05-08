$(document).ready(function($){
	var reulsts = $('#results');
		results = $(results);
	if(results.find('p').length > 0){
		results.fadeIn();
	}
	
	var obj = { 
		id_array: []
	}
	
	$('#results p').on('click', function(){
		var that = $(this);
		var id = $(this).attr('id');
			id = $(id);
			that.toggleClass('clicked');	

			//Store the clicked ID's
			obj.id_array.push(id.selector);
	});
	$('#results form .delete').on('click', function(event){
		event.preventDefault();
		//var obj;
		
		//var data = JSON.stringify(obj);
		//console.log(data);
		
		//obj = { test_msg: 'im a test message'}
		
		$.post('./delete.php', obj, function(returned_id){
			console.log(returned_id);
			
			var ids = returned_id.toString(),
				length = ids.split(',').length,
				id_array = ids.split(',');
				
				if (length === 1) {
					$('#' + returned_id).fadeOut();
				} else {
					$.each(id_array, function(index, val){
						var current = id_array[index];
						current = '#' + id_array[index];
						$(current).fadeOut();
					});
				}
				
		});
	});
});