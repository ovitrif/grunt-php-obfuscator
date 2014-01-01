<?php

class Encoder {
    public function __construct() {
        include_once( 'encryption.php' );
        include_once( 'obfuscator1.php' );
        include_once( 'obfuscator2.php' );
    }

    public function encode( $name, $path ) {
        $file = '../' . $path . '/' . $name;

        //First encoder
        $obfuscator = new PhpObfuscator();
        $obfuscatedFile = $obfuscator->obfuscate( $file );

        if ( $obfuscator->hasErrors() ) {
            $errors = $obfuscator->getAllErrors();
            print_r( $errors );
        } else {
            //Second encoder
            $packer = new Obfuscator();
            $packer->file( $obfuscatedFile );
            $packer->strip = false;
            $packer->strip_comments = false;
            $packer->b64 = true;
            $packer->pack();
            $packer->save( "../" . $path . "/obfuscated_" . $name );

            //obfuscating variables
            $enc = new Encryption();
            $enc->parse( "../" . $path . "/obfuscated_" . $name )->codeit( "../" . $path . "/obfuscated_" . $name );

            //deleting files
            unlink( $obfuscatedFile );
            unlink( $file );

            //echo result
            echo "obfuscated_" . $name;
        }
    }
}