<?php
declare(strict_types=1);
namespace Core\Driver;
use \Core\Driver\Interfaces\CacheInterface;
class Cache implements CacheInterface
{
    public function __construct()
    {
        
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, $default = null)
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value, $ttl = null)
    {
        // TODO: Implement set() method.
    }

    public function delete(string $key)
    {
        // TODO: Implement delete() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function getMultiple($keys, $default = null)
    {
        // TODO: Implement getMultiple() method.
    }

    public function setMultiple($values, $ttl = null)
    {
        // TODO: Implement setMultiple() method.
    }

    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }

    /**
     * @inheritDoc
     */
    public function has(string $key)
    {
        // TODO: Implement has() method.
    }
}