<?php

namespace Imjoehaines\Session;

use OutOfBoundsException;

class Session
{
    /**
     * @var array
     */
    private $storage;

    /**
     * @param array $storage
     */
    public function __construct(array &$storage)
    {
        $this->storage = &$storage;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool
    {
        return array_key_exists($key, $this->storage);
    }

    /**
     * @throws OutOfBoundsException when $key is not in the session
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $this->storage[$key];
        }

        throw $this->notInSession($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value) : void
    {
        $this->storage[$key] = $value;
    }

    /**
     * @throws OutOfBoundsException when $key is not in the session
     * @param string $key
     * @return void
     */
    public function delete(string $key) : void
    {
        if ($this->has($key)) {
            unset($this->storage[$key]);

            return;
        }

        throw $this->notInSession($key);
    }

    /**
     * @param string $key
     * @return OutOfBoundsException
     */
    private function notInSession(string $key) : OutOfBoundsException
    {
        return new OutOfBoundsException('The key "' . $key . '" was not found in the session');
    }
}
