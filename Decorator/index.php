<?php

interface iDisplayM {

    public function displayM();
}

class Message implements iDisplayM {

    private $message = '';

    public function __construct($message) {
        $this->message = ' normal ' . $message;
    }

    public function displayM() {
        return $this->message;
    }
}

abstract class MessageDecorator implements iDisplayM {

    protected $message = '';

    public function __construct(iDisplayM $decorator) {
    }

}

class MessageBold extends MessageDecorator {

    public function __construct(iDisplayM $message) {
        $this->message = ' bold ' . $message->displayM();
    }
    
    public function displayM() {
        return $this->message;
    }

}

class MessageItalic extends MessageDecorator {

    public function __construct(iDisplayM $message) {
        $this->message = ' italic ' . $message->displayM();
    }
    
    public function displayM() {
        return $this->message;
    }
}

$message = 'toto';

$decorator = new MessageItalic( new MessageBold( new Message($message)));

var_dump($decorator->displayM());