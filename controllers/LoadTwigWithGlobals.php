<?php

/**
 * Extiende Twig_Environment
 * Añade variables globales desde /controllers/globals.php
 */
class LoadTwigWithGlobals extends Twig_Environment
{
    function __construct($globals)
    {
        $loader = new Twig_Loader_Filesystem(ROOTDIR.'/');

        parent::__construct($loader);

        self::setGlobals($globals);

    }

    private function setGlobals($array)
    {
        foreach ($array as $key => $value) {
            self::addGlobal($key, $value);
        }
    }
}
