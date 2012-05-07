$(document).ready(function($){
	var reulsts = $('#results');
		results = $(results);
	if(results.find('p').length > 0){
		results.fadeIn();
	}
	
	var id_array = [];
	$('#results p').on('click', function(){
		var that = $(this);
		var id = $(this).attr('id');
			id = $(id);
			that.toggleClass('clicked');
			
			//Store the clided ID's
			id_array.push(id.selector);
			console.log(id_array);
	});
	$('#results form .delete').on('click', function(){
		//pass the data via ajax
		//var data = id_array;
		var data = 'test val';
		$.post('delete.php', function(ret_data){
			console.log('success', data);
		});
	});
});