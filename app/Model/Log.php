<?php
class Log extends AppModel {
    public $name = 'Log';
	
	public $validate = array(
        'users_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'O Usuário deve ser informado!'
            )
        ),
        'data_log' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A data do Log deve ser informada'
            )
        )
    );
}
?>