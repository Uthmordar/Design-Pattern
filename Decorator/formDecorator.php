<?php

interface iForm {

    public function getElement();
}

class Form implements iForm{

    private $element;

    public function __construct($form, $param = array()) {
        $start = '<form ';
        foreach ($param as $k => $v) {
            $start .= ' ' . $k . '=' . $v;
        }
        $start .= ' >';
        $this->element = $start . $form . '</form>';
    }

    public function getElement() {
        return $this->element;
    }
    
    public function __toString(){
        return $this->element;
    }

}

class Input implements iForm {

    private $input;

    public function __construct($param = array()) {
        $input = '<input ';
        foreach ($param as $k => $v) {
            $input .= ' ' . $k . '=' . $v;
        }
        $input .= ' /><br/><br/>';
        $this->input = $input;
    }

    public function getElement() {
        return $this->input;
    }

}

abstract class FormDecorator implements iForm {

    protected $element = array();

    public function __construct(iForm $element) {
        $this->form = $element;
    }

    public function getElement() {
        return $this->element;
    }
    
    public function __toString(){
        return $this->element;
    }
}

class LabelDecorator extends FormDecorator {

    public function __construct(iForm $input, $value) {
        $this->element = '<label>' . $value . '</label><br/>' . $input->getElement();
    }
}

class ErrorDecorator extends FormDecorator {

    public function __construct(iForm $message, $value) {
        $this->element = '<div class="error">' . $value . '</div>' . $message->getElement();
    }
}

$form = new LabelDecorator( new ErrorDecorator(new Input(['type'=>'text', 'placeholder'=>'texte']), 'erreur texte'), 'texte');
$form .= new LabelDecorator( new ErrorDecorator(new Input(['type'=>'password', 'placeholder'=>'password']), 'erreur password'), 'Password');

echo  new Form($form, ['method'=>'POST', 'enc-type'=>'multi-part/form-data', 'action'=>htmlentities($_SERVER['PHP_SELF'])]);