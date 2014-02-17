<?php

phpinfo();

class MyClass {
    private $id = null;

    function __construct( $id ) {
        // do some stuff
        $this->id = $id;

        return $id;
    }

    private function myprivatefunction() {
        return 'myprivatestring';
    }
}