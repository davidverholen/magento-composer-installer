<?php
/**
 * ComposerMapping.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Mapping;

use Composer\Package\PackageInterface;

/**
 * Class ComposerMapping
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ComposerMapping extends AbstractMapping
{
    const MAP_KEY = 'map';

    /**
     * isSupported
     *
     * checks if the mapping is supported by the package
     *
     * @param PackageInterface $package
     *
     * @return boolean
     */
    public function isSupported(PackageInterface $package)
    {
        return array_key_exists(self::MAP_KEY, $package->getExtra());
    }


    /**
     * getMappings
     *
     * returns the resulting mappings as array[array[$source, $target]]
     *
     * @return array
     */
    public function getMappings()
    {
        return $this->getComposerMap();
    }

    /**
     * getComposerMap
     *
     * @return mixed
     */
    protected function getComposerMap()
    {
        return $this->getPackage()->getExtra()[self::MAP_KEY];
    }
}
