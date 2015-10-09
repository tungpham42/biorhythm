<?php
/**
 * Class Minify_Cache_Redis
 * @package Minify
 */

/**
 * Redis-based cache class for Minify
 *
 * @package Minify
 * @author Indra BW <indwic@gmail.com>
 **/
class Minify_Cache_Redis {

    /**
     * Create a Minify_Cache_Redis object, to be passed to
     * Minify::setCache().
     *
     * @param Redis $redis already-connected instance
     *
     * @param int $expire seconds until expiration (default = 0
     * meaning the item will not get an expiration date)
     *
     * @return null
     */
    public function __construct($redis, $expire = 0)
    {
        $this->_redis = $redis;
        $this->_exp = $expire;
    }

    /**
     * Write data to cache
     *
     * @param string $id cache id
     *
     * @param string $data
     *
     * $return bool success
     */
    public function store($id, $data)
    {
        if ($this->_exp) {
            return $this->_redis->setex($id, $this->_exp,
                "{$_SERVER['REQUEST_TIME']}|{$data}");
        } else {
            return $this->_redis->set($id,
                "{$_SERVER['REQUEST_TIME']}|{$data}");
        }
    }

    /**
     * Get the size of a cache entry
     *
     * @param string $id cache id
     *
     * @return int size in bytes
     */
    public function getSize($id)
    {
        if (! $this->_fetch($id)) {
            return false;
        }
        return (function_exists('mb_strlen') &&
            ((int) ini_get('mbstring.func_overload') & 2))
            ? mb_strlen($this->_data, '8bit')
            : strlen($this->_data);
    }

    /**
     * Does a valid cache entry exist?
     *
     * @param string $id cache id
     *
     * @param int $srcMtime mtime of the original source file(s)
     *
     * @return bool exists
     */
    public function isValid($id, $srcMtime)
    {
        return ($this->_fetch($id) && ($this->_lm >= $srcMtime));
    }

    /**
     * Send the cached content to output
     *
     * @param string $id cache id
     */
    public function display($id)
    {
        echo $this->_fetch($id) ? $this->_data : '';
    }

    /**
     * Fetch the cached content
     *
     * @param string $id cache id
     *
     * @return string
     */
    public function fetch($id)
    {
        return $this->_fetch($id) ? $this->_data : '';
    }

    private $_redis = null;
    private $_exp = null;

    // cache of most recently fetched id
    private $_lm = null;
    private $_data = null;
    private $_id = null;

    /**
     * Fetch data and timestamp from redis, store in instance
     *
     * @param string $id
     *
     * @return bool success
     */
    private function _fetch($id)
    {
        if ($this->_id === $id) {
            return true;
        }
        $ret = $this->_redis->get($id);
        if (false === $ret) {
            $this->_id = null;
            return false;
        }
        list($this->_lm, $this->_data) = explode('|', $ret, 2);
        $this->_id = $id;
        return true;
    }
}
