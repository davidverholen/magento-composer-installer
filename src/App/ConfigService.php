<?php
/**
 * ConfigService.php
 *
 * PHP Version 5
 *
 * @category magento-composer-installer
 * @package  magento-composer-installer
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\App;

use Composer\Composer;

/**
 * Class ConfigService
 *
 * @category magento-composer-installer
 * @package  DavidVerholen\Magento\Composer\Installer\App
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ConfigService
{
    const CONFIG_KEY_RELEASE_DIR = 'release-dir';
    const CONFIG_KEY_RELEASE_COUNT = 'release-count';
    const CONFIG_KEY_PERSISTENT_DIR = 'persistent-dir';
    const CONFIG_KEY_PERSISTENT_TARGETS = 'persistent-targets';

    /**
     * @var array
     */
    protected $defaults
        = [
            self::CONFIG_KEY_RELEASE_DIR        => 'release',
            self::CONFIG_KEY_RELEASE_COUNT      => '3',
            self::CONFIG_KEY_PERSISTENT_DIR     => 'persistent',
            self::CONFIG_KEY_PERSISTENT_TARGETS => [
                'var',
                'media',
                'app/etc'
            ]
        ];


    /**
     * @var Composer
     */
    protected $composer;

    /**
     * ConfigService constructor.
     *
     * @param Composer $composer
     */
    public function __construct(Composer $composer)
    {
        $this->composer = $composer;
    }

    /**
     * getReleaseDir
     *
     * @return string
     */
    public function getReleaseDir()
    {
        return (string)$this->getConfig(self::CONFIG_KEY_RELEASE_DIR);
    }

    /**
     * getReleaseCount
     *
     * @return int
     */
    public function getReleaseCount()
    {
        return (int)$this->getConfig(self::CONFIG_KEY_RELEASE_COUNT);
    }

    /**
     * getPersistentDir
     *
     * @return string
     */
    public function getPersistentDir()
    {
        return (string)$this->getConfig(self::CONFIG_KEY_PERSISTENT_DIR);
    }

    /**
     * getPersistentTargets
     *
     * @return array
     */
    public function getPersistentTargets()
    {
        return (array)$this->getConfig(self::CONFIG_KEY_PERSISTENT_TARGETS);
    }

    /**
     * getConfig
     *
     * @param            $key
     * @param bool|false $isRequired
     *
     * @return null
     * @throws ConfigKeyNotDefinedException
     */
    protected function getConfig($key, $isRequired = false)
    {
        $this->validateConfigKey($key, $isRequired);

        if (false === $isRequired
            && false === isset($this->getExtraArray()[$key])
        ) {
            return $this->getDefault($key);
        }

        return $this->getExtraArray()[$key];
    }

    /**
     * getDefault
     *
     * @param $key
     *
     * @return null
     */
    protected function getDefault($key)
    {
        if (isset($this->defaults[$key])) {
            return $this->defaults[$key];
        }

        return null;
    }

    /**
     * validateConfigKey
     *
     * @param            $key
     * @param bool       $isRequired
     *
     * @return void
     * @throws ConfigKeyNotDefinedException
     */
    protected function validateConfigKey($key, $isRequired = false)
    {
        if ($isRequired && false === isset($this->getExtraArray()[$key])) {
            throw new ConfigKeyNotDefinedException($key);
        }
    }

    /**
     * getExtraArray
     *
     * @return array
     */
    protected function getExtraArray()
    {
        return $this->getComposer()->getPackage()->getExtra();
    }

    /**
     * @return Composer
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * @param Composer $composer
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;
    }
}
