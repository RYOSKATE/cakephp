<?php 
	if($userData['role']!='reader')
	{

		echo $this->Form->create('Graph',array('inputDefaults' => 
											array('div' => 'form-group',),
											'class' => 'well form-inline')
											);
?>
	<fieldset>
			
	<!--// 折り畳み展開ポインタ -->
		<div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">
			<legend><a style="cursor:pointer;">付箋▼</a></legend>
		</div>
		<!-- 折り畳まれ部分 -->
		<div id="open" style="display:none;clear:both;">
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
						'options'=>array('#FFFFFF' => '白','#C869FF' => '紫', '#6BCDFF' => '青', '#71FD5E' => '緑', '#FECA61' => '黄', '#FA6565' => '赤'),
						'class' => 'form-control'
					));
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-12 col-md-12 col-lg-6">';       
					echo $this->Form->input('id',array
					(
						'id'=> 'id',
						'type'=>'number',
						'class' => 'form-control',
						'step'=>1,
						'min'=>0,
						'max'=>end($stickies)['id'],
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
						'min'=>0,
						'value'=>350,
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
						'min'=>0,
						'value'=>490,
						'style'=>"width:100%;",
						// 'list'=>array(1,2,3),
					));     
					echo '</div>';
					echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">';    
					echo $this->Form->input('add', array
					(
						'id'=> 'add',
						'label'=>false,
						'name'=>'add',
						'type'=>'button',
						'onchange' => 'submit(this.form)',
						'class' => 'form-control',
						'value'=>'add',
						'style'=>"width:100%;",
					));    
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-6 col-md-12 col-lg-4">';    
					echo $this->Form->input('edit', array
					(
						'id'=> 'edit',
						'name'=>'edit',
						'label'=>false,
						'type'=>'button',
						'onchange' => 'submit(this.form)',
						'class' => 'form-control',
						'value'=>'edit',
						'style'=>"width:100%;",
					));     
					echo '</div>';
					echo '<div class="col-xs-6 col-sm-12 col-md-12 col-lg-4">';    
					echo $this->Form->input('delete', array
					(
						'id'=> 'delete',
						'label'=>false,
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
		</div>	
	</fieldset>
<?php
		echo $this->Form->end();
	}
?>
