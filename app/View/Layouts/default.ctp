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
		//echo $this->Html->script('amcharts/serial');
		//echo $this->Html->script('amcharts/amstock');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<style>
	.sticky {
	  width: 250px;
	  height: 250px;
	  position: absolute;
	  cursor: pointer;
	  border: 1px solid #aaa;
	}
	textarea {
	  width: 300px;
	  height: 300px;
	}

	#textarea {
	  height: 100px;
	  resize: vertical;
	}
	.selected {border-color: #000;}
</style>
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
		          <ul class="nav navbar-nav navbar-right">
		            <li class="active"><?php echo $this->Html->link($userData['username'],array('controller' => 'users',  'action' => 'delete'));?></li>
		          <?php if($userData['role']!='reader'){?>
		            <li class="active"><?php echo $this->Html->link('Upload',array('controller' => 'users', 'action' => 'delete'));?></li>
		            <?php }?>
		            <li class="active"><?php echo $this->Html->link('Logout',array('controller' => 'users',  'action' => 'logout'));?></li>
		          </ul>
		        </div><!--/.nav-collapse -->
			  </div>
			</nav>
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>

		<div class="container">
   		<div class="row">
   			<!-- 3列をサイドメニューに割り当て -->
	        <div class="col-md-3 col-sm-3">
	        	<div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
				  <div class="list-group-item active">全開発グループ</div>
				  <?php echo $this->Html->link('欠陥数散布図',array('controller' => 'graphs', 'action' => 'alldevgroup'),array('class' =>'list-group-item'));?>
				</div>

		        <div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
				  <div class="list-group-item active">各開発グループ</div>
				  
				  <?php echo $this->Html->link('メトリクス遷移',array('controller' => 'graphs', 'action' => 'onedevgroup'),array('class' =>'list-group-item'));?>
				  <?php echo $this->Html->link('ファイルメトリクス',array('controller' => 'graphs', 'action' => 'onedevgroup2'),array('class' =>'list-group-item'));?>
				</div>

				<div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
				  <div class="list-group-item active">モデル</div>
				  <?php echo $this->Html->link('由来比較',		array('controller' => 'graphs', 'action' => 'origin'), array('class' =>'list-group-item'));?>
				  <?php echo $this->Html->link('メトリクス比較',array('controller' => 'graphs', 'action' => 'metrics'),array('class' =>'list-group-item'));?>
				</div>
<!-- 付箋追加削除 -->



<?php 

if($userData['role']!='reader'){
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline')
                                        );
    echo $this->Form->input('textarea', array
    (
    	'id'=> 'textarea',
    	'label'=>false,
    	'type'=>'textarea',
    	'class' => 'col-md-12 col-sm-12',
    	'value'=>'',
    ));
    echo $this->Form->input('color',array
	(
		'id'=>'color',
	    'type'=>'select',
	    'options'=>array('#FFFFFF' => '白','#C869FF' => '紫', '#6BCDFF' => '青', '#71FD5E' => '緑', '#FECA61' => '黄', '#FA6565' => '赤'),
	    'class' => 'form-control'
	 ));
   	echo $this->Form->input('id',array
	(
		'id'=> 'id',
	    'type'=>'number',
	    'class' => 'form-control',
	    'step'=>1,
	    'min'=>0,
	    'max'=>end($stickies)['id'],
	    'value'=>0,
	    // 'list'=>array(1,2,3),
	 ));
   	echo $this->Form->input('x',array
	(
		'id'=> 'left',
	    'type'=>'number',
	    'class' => 'form-control',
	    'step'=>1,
	    'min'=>0,
	    'value'=>77,
	    // 'list'=>array(1,2,3),
	 ));
   	echo $this->Form->input('y',array
	(
		'id'=> 'top',
	    'type'=>'number',
	    'class' => 'form-control',
	    'step'=>1,
	    'min'=>0,
	    'value'=>777,
	    // 'list'=>array(1,2,3),
	 ));
   	echo $this->Form->input('add', array
    (
    	'id'=> 'add',
    	'label'=>false,
    	'name'=>'add',
    	'type'=>'button',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control',
    	'value'=>'add',
    ));
    echo $this->Form->input('delete', array
    (
    	'id'=> 'delete',
    	'label'=>false,
    	'name'=>'delete',
    	'type'=>'button',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control',
    	'value'=>'delete',
    ));
    echo $this->Form->input('edit', array
    (
    	'id'=> 'edit',
    	'name'=>'edit',
    	'label'=>false,
    	'type'=>'button',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control',
    	'value'=>'edit',
    ));
    echo $this->Form->end();
}
    ?>
<!-- 付箋追加削除 -->
	        </div>
	        <!-- 残り9列はコンテンツ表示部分として使う -->
	        <div class="col-md-9 col-sm-9">
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

</body>
</html>
<script>
// forked from naga3's "クッキーに保存できる付箋" http://jsdo.it/naga3/iEvs
$(function() {


  function make(item) {
    var sticky = $('<div class="sticky"></div>');
    sticky.appendTo('body')
      .draggable()
      .mousedown(function() {
        $('.sticky').removeClass('selected');
        $(this).addClass('selected');
        document.getElementById("textarea").value=item.text;
        document.getElementById("id").value=item.id;
        document.getElementById("color").value=item.color;
      })
      .mouseup(function() {
        document.getElementById("left").value=$(this).context.offsetLeft
        document.getElementById("top").value=$(this).context.offsetTop;
      });
    return sticky;
  }

    function load() {
    var items = [];
    var stickies=JSON.parse('<?=json_encode($stickies);?>');
    for(var i=0;i<stickies.length;++i)
    {
    	items.push({
        css: {
          left: Number(stickies[i].left),
    	  top: Number(stickies[i].top),
          backgroundColor: stickies[i].color,
        },
        html: "No:"+stickies[i].id+" "
        	 +"User:"+stickies[i].username+"<br>"
        	 +"Date:"+stickies[i].time+"<br>"
        		+stickies[i].text,
        id : stickies[i].id,
        text :stickies[i].text,
        color:stickies[i].color
      });
    }
    if (!(0<items.length))
    {
    	return;
    }
    $.each(items, function(i, item) {
      make(item).css(item.css).html(item.html);
    });
  }
  load();
});
</script>