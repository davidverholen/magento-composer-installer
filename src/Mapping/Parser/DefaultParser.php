<?php
/**
 * DefaultMapping.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Mapping\Parser;

use Composer\Package\PackageInterface;
use DavidVerholen\Magento\Composer\Installer\Mapping\Map;
use DavidVerholen\Magento\Composer\Installer\Mapping\MapCollection;

/**
 * Class DefaultMapping
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DefaultParser extends AbstractParser
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
        return true;
    }

    /**
     * getMappings
     *
     * returns the resulting mappings as Collection
     *
     * @return MapCollection
     */
    public function getMappings()
    {
        $this->getMapCollection()->reset();
        $this->getMapCollection()->addMap(new Map('.', '.'));

        return $this->getMapCollection();
    }
}
