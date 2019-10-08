<?php
namespace Core\Framework;
class Filter
{
    private static $type;
    private static $instance;

    private function __construct(array $type)
    {
        self::$type;
    }

    private function clone() {}

    public static function getInstance(array $type)
    {
        if(!self::$instance) {
            return new self($type);
        }
        return self::$instance;
    }

    public static function check()
    {
        
    } 
}