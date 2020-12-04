<?php
declare(strict_types=1);
namespace Core\Driver\Interfaces;
interface LogInterface
{
    // public function emergency(string $message, array $context = []);

    // public function alert(string $message, array $context = []);

    // public function critical(string $message, array $context = []);

    public function error(string $message = null, array $context = []);

    public function warning(string $message = null, array $context = []);

    public function notice(string $message = null, array $context = []);

    public function info(string $message = null, array $context = []);

    public function debug(string $message = null, array $context = []);

    // public function log(string $message, array $context = []);

}