<?php
declare(strict_types=1);
namespace Core\Driver\Interfaces;
interface CacheInterface
{
    /**
     * @param  string $key
     * @param  mixed  $default
     * @return mixed  
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     */
    public function set(string $key, $value, $ttl = null);

    public function delete(string $key);

    public function clear();

    public function getMultiple($keys, $default = null);

    public function setMultiple($values, $ttl = null);

    public function deleteMultiple($keys);

    /**
     * @param  string $key
     * @return bool
     */
    public function has(string $key);

}