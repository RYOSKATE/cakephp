<div class="container">  
<div class="row">
<div class="col-md-6 col-md-offset-3">

    <div class="list-group nav nav-tabs nav-stacked fixed-sidebar">
	  <div class="list-group-item active">アカウント操作</div>
	  <?php if($userData['role']=='admin'){?>
	  <?php echo $this->Html->link('追加',array('controller' => 'users', 'action' => 'add'),array('class' =>'list-group-item'));?>
	  <?php }?>
	  <?php echo $this->Html->link('削除',array('controller' => 'users', 'action' => 'delete'),array('class' =>'list-group-item'));?>

	</div>
</div>
</div>
</div>
