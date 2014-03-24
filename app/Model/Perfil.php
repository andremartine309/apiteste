<?php
class Perfil extends AppModel {
    public $name = 'Perfil';
	public $useTable = 'perfis';
	public $hasMany = 'Perfil';
    public $validate = array(
        'nome_perfil' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Informe o nome do perfil'
            )
        )
    );
}
?>