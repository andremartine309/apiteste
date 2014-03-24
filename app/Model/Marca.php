<?php
class Marca extends AppModel {
    public $name = 'Marca';
	//public $hasMany = 'Carro';
    public $validate = array(
        'marca' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Informe a marca'
            )
        )
    );
}
?>