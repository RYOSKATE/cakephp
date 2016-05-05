<?php 

    echo $this->element('formCreate');
    echo '<div class="row">';
        for($i=1;$i<=4;++$i)
        {
            echo '<div class="col-sm-6 col-md-3 col-lg-3">';    
            echo $this->Form->input('モデル'.$i,array
            (
                'type'=>'select',
                'options'=>$modelName,
                'label'=>__('モデル選択'.$i),
                'class' => 'form-control',
                'style'=>"width:100%;",
                'empty' => 1<$i,
            ));
            echo '</div>';
        }
        echo '<div class="col-sm-6 col-md-4 col-lg-4">';  
        echo $this->element('selectGroup',$groupName);
        echo '</div>';
        echo '<div class="col-sm-6 col-md-8 col-lg-8">';  
        echo $this->element('selectMetrics',array($metricsList));
        echo '</div>';
        echo '<div class="col-sm-12 col-md-12 col-lg-12">';  
        echo $this->element('setButton');
        echo '</div>';
    echo '</div>';
    echo $this->Form->end();
?>