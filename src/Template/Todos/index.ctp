<?php $this->Html->script('app', ['block' => true]); ?>

<div class="col-md-4 col-md-offset-4">
	<form action="/todos/add.json" class="form-inline" role="form" id="add-to-do">
		<div class="form-group">
		 	<div class="input-append" id="task-input">
			  <input class="form-control input-lg" name="to-do" type="text" id="inputLarge" placeholder="Enter a task...">
			  <button type="submit" class="btn btn-primary btn-lg">Add To-do</button>
		  	</div>
	  	</div>
	</form>
	<div class="task-container" id="to-dos">
		<form action="/todos/finish.json" class="form-inline" role="form" id="finish-to-do">
			<div id="incomplete-label"><h5>To do:</h5></div>
			<div class="form-group" id="incomplete-to-dos"></div>
		</form>
	</div>
	<div class="task-container">
		<div id="done-label"><h5>Recently done...</h5></div>
		<div id="done"></div>
	</div>
</div>