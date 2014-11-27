var TodoApp = {};

(function(){
	TodoApp.getTodos = function() { $.get('/todos/get.json', function(response) {
		$label = $('#incomplete-label');
		$incompleteDiv = $('#incomplete-to-dos');
		$incompleteDiv.empty();
    	if (response.todos.length === 0) {
    		$label.hide();
    		$incompleteDiv.append('<div class="incomplete-todo">All done. Have a nice day (or add a new to-do above).</div>');
		} else {
			$label.show();
    		$.each(response.todos, function(key, value) {
				$incompleteDiv.append('<div class="incomplete-todo" id="incomplete-' + value.id +'"><label for="todo_' + value.id + '">' + value.todo + ' <input id="todo_' + value.id + '" class="todo-checked" type="checkbox" /></label><div class="small-done">' + value.created + '</div></div>');
				$incompleteDiv.show('highlight');
			});
		}
 	});
};

	TodoApp.getDone = function() { $.get('/todos/get/1.json', function(response) {
			$doneDiv = $('#done');
			$doneDiv.empty();
	      	$.each(response.todos, function(key, value) {
	  			$doneDiv.append('<div class="finished-task"><div class="finshed-task-text">' + value.todo + '</div><div class="small">' + value.updated + '</div></div>');
	  		});
	  	});
	};

	TodoApp.finishTask = function(id) {
		$.get('/todos/finish/' + id + '.json',
			function(response) {
			    if (response.response.result == 'success') {
					$('#incomplete-' + id).hide('explode');
					$('#incomplete-' + id).remove();
					TodoApp.getTodos();
    				TodoApp.getDone();
			    } else if (response.response.result == 'fail') {
			    	console.log('fail');
			    }
		  	}
		);
	};

})();

(function($) {
 	$("#add-to-do").submit(function(event) {
		$('#todo-error').remove();
		$('.form-group').removeClass('has-error');
		var $form = $(this),
			todo = $form.find("input[name='to-do']").val(),
			url = $form.attr('action');

		var posting = $.post( url, { todo : todo } );
		posting.done(function( response ) {
		    if (response.response.result == 'success') {
		    	$('#incomplete-to-dos').empty();
		    	$('#inputLarge').val('');
		    	TodoApp.getTodos();
		    } else if (response.response.result == 'fail') {
		    	$('.form-group').addClass('has-error');
		    	$('#task-input').append('<div class="error" id="todo-error">' + response.response.error.todo + '</div>');
		    }
		});
		event.preventDefault();
	});

    $(document).on('click', ':checkbox', function() {
 		var id = $(this).attr('id').replace('todo_', '');
  		TodoApp.finishTask(id);
	});

   	TodoApp.getTodos();
    TodoApp.getDone();
})(jQuery);