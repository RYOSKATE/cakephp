<div class="container">  
<div class="row">
<div class="col-md-6 col-md-offset-3">

    <div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
	  <div class="list-group-item active">アカウント操作</div>
	  <?php if($userData['role']=='admin'){?>
	  <?php echo $this->Html->link('管理',array('controller' => 'users', 'action' => 'index'),array('class' =>'list-group-item'));?>
	  <?php }?>
	  <?php echo $this->Html->link('変更',array('controller' => 'users', 'action' => 'ownEdit'),array('class' =>'list-group-item'));?>
	  <?php echo $this->Html->link('削除',array('controller' => 'users', 'action' => 'onwDelete'),array('class' =>'list-group-item'));?>
	</div>
</div>
</div>
</div>
