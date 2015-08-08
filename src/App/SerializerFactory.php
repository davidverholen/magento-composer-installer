<?php
/**
 * SerializerFactory.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\App;

use Composer\Composer;
use DavidVerholen\Magento\Composer\Installer\App\Di\ContainerFactory;
use DavidVerholen\Magento\Composer\Installer\Plugin;
use JMS\Serializer\SerializerBuilder;

/**
 * Class SerializerFactory
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  App
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class SerializerFactory
{
    const APP_SERIALIZER_CONFIG_DIR = 'serializer';

    /**
     * @var string
     */
    protected static $metaDataDir;

    /**
     * @var Composer
     */
    protected static $composer;

    /**
     * @var Plugin
     */
    protected static $plugin;

    /**
     * createSerializer
     *
     * @return \JMS\Serializer\Serializer
     * @throws \Exception
     */
    public static function createSerializer()
    {
        if (null === self::getMetadataDir()) {
            throw new \Exception('No Metadatadir set for Serializer Factory');
        }

        return SerializerBuilder::create()
            ->addMetadataDir(self::$metaDataDir)
            ->build();
    }

    /**
     * setMetadataDir
     *
     * @return string
     *
     */
    public static function getMetadataDir()
    {
        if (null === self::$metaDataDir) {
            self::$metaDataDir = implode(
                DIRECTORY_SEPARATOR,
                [
                    ContainerFactory::getInstance()->getServiceConfigDir(),
                    self::APP_SERIALIZER_CONFIG_DIR
                ]
            );
        }

        return self::$metaDataDir;
    }

    /**
     * @param string $metaDataDir
     */
    public static function setMetaDataDir($metaDataDir)
    {
        self::$metaDataDir = $metaDataDir;
    }

    /**
     * @return Composer
     */
    public static function getComposer()
    {
        return self::$composer;
    }

    /**
     * @param Composer $composer
     */
    public static function setComposer($composer)
    {
        self::$composer = $composer;
    }

    /**
     * @return Plugin
     */
    public static function getPlugin()
    {
        return self::$plugin;
    }

    /**
     * @param Plugin $plugin
     */
    public static function setPlugin($plugin)
    {
        self::$plugin = $plugin;
    }
}
