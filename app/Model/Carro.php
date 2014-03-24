<?php
class Carro extends AppModel {
    public $name = 'Carro';
    public $validate = array(
    	'modelo_carro' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Informe o modelo do carro'
            )
        ),
        'ano' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Informe o ano do carro'
            )
        ),
        'valor' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Informe o valor do carro'
            )
        ),
        'nr_parcelas' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Informe o núemero de parcelas'
            )
        )
    );
}
?>