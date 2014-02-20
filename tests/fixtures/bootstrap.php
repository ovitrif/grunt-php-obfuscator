<?php

/**
 * Class Bootstrap
 */
class Bootstrap {

    /**
     * Initialization
     */
    public static function init() {
        self::constants();

        self::classes();
        self::functions();

        self::actions();
    }

    /**
     * Constants
     */
    private static function constants() {
        define( 'PREFIX', 'pre' );
    }

    /**
     * Classes
     */
    private static function classes() {
        include_once( 'firstclass.php' );
        include_once( 'secondclass.php' );
    }

    /**
     * Functions
     */
    private static function functions() {
        include_once( 'functions.php' );
    }

    /**
     * Actions
     */
    private static function actions() {
        add_action( 'internal_action', 'internal_action_callback' );
    }
}

Bootstrap::init();