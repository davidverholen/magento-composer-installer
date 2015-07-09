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
        return array_key_exists('map', $package->getExtra());
    }


    /**
     * getMappings
     *
     * returns the resulting mappings as array[source] = target
     *
     * @return array
     */
    public function getMappings()
    {
        $result = [];
        foreach ($this->getComposerMap() as $mapping) {
            $result[$mapping[0]] = $mapping[1];
        }

        return $result;
    }

    /**
     * getComposerMap
     *
     * @return mixed
     */
    protected function getComposerMap()
    {
        $extra = $this->getPackage()->getExtra();
        return $extra['map'];
    }
}
