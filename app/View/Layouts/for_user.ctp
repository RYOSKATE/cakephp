<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('mystyle');
		echo $this->Html->css('bootstrap.min');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container">
		<div id="header">
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			  <div class="container">
			    <div class="navbar-header">
			    	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          	</button>
		          	<?php echo $this->Html->link('Visualize Tool',array('controller' => 'graphs', 'action' => 'index'),array('class' =>'navbar-brand'));?>
		        </div>
		        <div class="navbar-collapse collapse">
		          <ul class="nav navbar-nav navbar-left">
		            <!--<li class="active"><?php //echo $this->Html->link('Logout',array('controller' => 'users', 'action' => 'logout'));?></li>-->
		            <li class="divider-vertical"><?php echo $this->Html->link('Login',array('controller' => 'users', 'action' => 'login'));?></li>
		            <li class="divider-vertical"><?php echo $this->Html->link('Add',array('controller' => 'users', 'action' => 'add'));?></li>
		          </ul>
		        </div><!--/.nav-collapse -->
			  </div>
			</nav>
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>

		<div class="container">
   		<div class="row">
	         	<div id="content">
					<?php echo $this->Session->flash(); ?>

					<?php echo $this->fetch('content'); ?>
				</div>
	     </div>
	    </div>

		<div id="footer">
			<p>
				<?php //echo $cakeVersion; ?>
			</p>
		</div>
	</div>

</body>
</html>
