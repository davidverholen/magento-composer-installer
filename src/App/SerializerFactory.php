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
    /**
     * @var string
     */
    protected static $metaDataDir;

    /**
     * createSerializer
     *
     * @return \JMS\Serializer\Serializer
     * @throws \Exception
     */
    public static function createSerializer()
    {
        if (null === self::$metaDataDir) {
            throw new \Exception('No Metadatadir set for Serializer Factory');
        }

        return SerializerBuilder::create()
            ->addMetadataDir(self::$metaDataDir)
            ->build();
    }

    /**
     * setMetadataDir
     *
     * @param $metaDataDir
     *
     * @return void
     */
    public static function setMetadataDir($metaDataDir)
    {
        self::$metaDataDir = $metaDataDir;
    }
}
