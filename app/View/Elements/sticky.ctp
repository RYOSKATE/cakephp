<?php 
	if($userData['role']!='reader')
	{

		echo $this->Form->create('Graph',array('inputDefaults' => 
											array('div' => 'form-group',),
											'class' => 'well form-inline')
											);
?>
	<fieldset>
		<legend><?php echo __('付箋');?></legend>

			<div class="row">

				<?php
					echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
					echo $this->Form->input('textarea', array
					(
						'id'=> 'textarea',
						'label'=>false,
						'type'=>'textarea',
						'style'=>"width:100%;",
					));     
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-6 col-md-12 col-lg-6">';    
					echo $this->Form->input('color',array
					(
						'id'=>'color',
						'type'=>'select',
						'options'=>array('#FFFFFF' => __('白'),'#C869FF' => __('紫'), '#6BCDFF' => __('青'), '#71FD5E' => __('緑'), '#FECA61' => __('黄'), '#FA6565' => __('赤')),
						'class' => 'form-control'
					));
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-12 col-md-12 col-lg-6">';       
					$temp = end($stickies);
					echo $this->Form->input('id',array
					(
						'id'=> 'id',
						'type'=>'number',
						'class' => 'form-control',
						'step'=>1,
						'min'=>0,
						'max'=>$temp['id'],
						'value'=>0,
						'style'=>"width:100%;",
						// 'list'=>array(1,2,3),
					));
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-12 col-md-12 col-lg-6">';    
					echo $this->Form->input('x',array
					(
						'id'=> 'left',
						'type'=>'number',
						'class' => 'form-control',
						'step'=>1,
						//'min'=>0,
						'value'=>350.0,
						'style'=>"width:100%;",
						// 'list'=>array(1,2,3),
					));    
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-12 col-md-12 col-lg-6">';    
					echo $this->Form->input('y',array
					(
						'id'=> 'top',
						'type'=>'number',
						'class' => 'form-control',
						'step'=>1,
						//'min'=>0,
						'value'=>490.0,
						'style'=>"width:100%;",
						// 'list'=>array(1,2,3),
					));     
					echo '</div>';
					echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">';    
					echo $this->Form->input(__('add'), array
					(
						'id'=> 'add',
						'label'=>' ',
						'name'=>'add',
						'type'=>'button',
						'onchange' => 'submit(this.form)',
						'class' => 'form-control',
						'value'=>'add',
						'style'=>"width:100%;",
					));    
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-6 col-md-12 col-lg-6">';    
					echo $this->Form->input(__('edit'), array
					(
						'id'=> 'edit',
						'name'=>'edit',
						'label'=>' ',
						'type'=>'button',
						'onchange' => 'submit(this.form)',
						'class' => 'form-control',
						'value'=>'edit',
						'style'=>"width:100%;",
					));     
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-12 col-md-12 col-lg-12">';    
					echo $this->Form->input(__('delete'), array
					(
						'id'=> 'delete',
						'label'=>' ',
						'name'=>'delete',
						'type'=>'button',
						'onchange' => 'submit(this.form)',
						'class' => 'form-control',
						'value'=>'delete',
						'style'=>"width:100%;",
					));    
					echo '</div>';
				?>

		</div>	
	</fieldset>
<?php
		echo $this->Form->end();
	}
?>
