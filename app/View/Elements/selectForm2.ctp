<?php 
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline',
                                        )
                            );

    echo $this->Form->input('モデル1',array
    (
        'type'=>'select',
        'options'=>$modelName,
        'class' => 'form-control'
     ));
    echo $this->Form->input('モデル2',array
    (
        'type'=>'select',
        'options'=>$modelName,
        'class' => 'form-control'
     ));
    echo $this->element('selectGroup',$groupName);
    echo $this->element('setButton');

    echo $this->Form->end();

?>