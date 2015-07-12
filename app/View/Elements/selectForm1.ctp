<?php 
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline')
                                        );
    echo $this->element('selectModel',$modelName);
    echo $this->element('selectGroup',$groupName); 
    echo $this->element('setButton'); 
    echo $this->Form->end();
?>