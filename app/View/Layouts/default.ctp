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
* @since         CakePHP(tm) v 0.10.0.1076metrics.js
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

		<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('mystyle');
		echo $this->Html->css('amcharts');
		echo $this->Html->css('bootstrap.min');
		//echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('amcharts/amcharts');
		echo $this->Html->script('fabric.min');
		echo $this->Html->script('three.min');
		echo $this->Html->script('OrbitControls');
		//echo $this->Html->script('amcharts/serial');
		//echo $this->Html->script('amcharts/amstock');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->css('sticky');
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
						<?php echo $this->Html->link(__('Visualize Tool'),array('controller' => 'graphs', 'action' => 'index'),array('class' =>'navbar-brand'));?>
						<?php echo $this->Html->link('日本語',array('controller' => 'graphs', 'action' => 'index/lang:jpn'),array('class' =>'navbar-brand'));?>
						<?php echo $this->Html->link('English',array('controller' => 'graphs', 'action' => 'index/lang:eng'),array('class' =>'navbar-brand'));?>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">

							<li><?php echo $this->Html->link($userData['username'],array('controller' => 'users',  'action' => 'manage'));?></li>
							<?php if($userData['role']!='reader'){?>
							<li><?php echo $this->Html->link(__('Upload'),array('controller' => 'graphs', 'action' => 'upload'));?></li>
							<li><?php echo $this->Html->link(__('Layer'),array('controller' => 'layers', 'action' => 'index'));?></li>
							<li><?php echo $this->Html->link(__('LayerPath'),array('controller' => 'layerpaths', 'action' => 'index'));?></li>
							<?php }?>
							<li><?php echo $this->Html->link(__('Data'),array('controller' => 'upload_data', 'action' => 'index'));?></li>
							<li><?php echo $this->Html->link(__('Logout'),array('controller' => 'users',  'action' => 'logout'));?></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</nav>
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>

		<div class="container">
			<div class="row">
				<!-- 3列をサイドメニューに割り当て -->
				<div class="col-xs-12 col-sm-3 col-md-2 col-lg-3">
					<div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
						<div class="list-group-item active"><?php echo __('全開発グループ');?></div>
						<?php echo $this->Html->link(__('メトリクス散布図'),		   array('controller' => 'graphs', 'action' => 'alldevgroup'), array('class' =>'list-group-item'));?>
					</div>
					<div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
						<div class="list-group-item active"><?php echo __('各開発グループ');?></div>
						<?php echo $this->Html->link(__('メトリクス遷移'),		  array('controller' => 'graphs', 'action' => 'onedevgroup'), array('class' =>'list-group-item'));?>
						<?php echo $this->Html->link(__('メトリクスファイルマップ'),	array('controller' => 'graphs', 'action' => 'onedevgroup2'),array('class' =>'list-group-item'));?>
					</div>
					<div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
						<div class="list-group-item active"><?php echo __('レイヤー');?></div>
						<?php echo $this->Html->link(__('メトリクスレーダーチャート'),		  array('controller' => 'graphs', 'action' => 'metrics'),	  array('class' =>'list-group-item'));?>
					</div>
					<div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
						<div class="list-group-item active"><?php echo __('由来');?></div>
						<?php echo $this->Html->link(__('メトリクス円グラフ'),   array('controller' => 'graphs', 'action' => 'origin'), 	 array('class' =>'list-group-item'));?>
						<?php echo $this->Html->link(__('メトリクス領域図'),	  array('controller' => 'graphs', 'action' => 'originCity'),  array('class' =>'list-group-item'));?>
						<?php echo $this->Html->link(__('Origin City'), array('controller' => 'graphs', 'action' => 'originCity2'), array('class' =>'list-group-item'));?>
					</div>
					<!-- 付箋 -->

					<?php echo $this->element('sticky'); ?>
				</div>
				<!-- 残り9列はコンテンツ表示部分として使う -->
				<div class="col-xs-12 col-sm-9 col-md-10 col-lg-9">
					<div id="content">
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->fetch('content'); ?>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<p>
				<?php //echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<script type="text/javascript">
		var stickies = JSON.parse('<?=json_encode($stickies);?>');
	</script>
	<?php echo $this->Html->script('sticky', array('inline' => true)); ?>
	</body>
</html>
