<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= 'To-do : an awesome CakePHP 3 app : ' . $this->fetch('title') ?>
	</title>

	<?= $this->Html->css('bootstrap.min') ?>
	<?= $this->Html->css('app') ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
</head>
<body>
	<div id="container">
		<?= $this->fetch('content') ?>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<?= $this->fetch('script') ?>
</body>
</html>
