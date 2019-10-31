<?php
namespace Core\Driver\Interfaces;
interface LogInterface
{
    // public function emergency(string $message, array $context = []);

    // public function alert(string $message, array $context = []);

    // public function critical(string $message, array $context = []);

    public function error($message = null, array $context = []);

    public function warning($message = null, array $context = []);

    public function notice($message = null, array $context = []);

    public function info($message = null, array $context = []);

    public function debug($message = null, array $context = []);

    // public function log(string $message, array $context = []);

}