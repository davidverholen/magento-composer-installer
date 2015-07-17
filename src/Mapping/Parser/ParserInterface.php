<?php
 /**
 * MappingInterface.php
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
use DavidVerholen\Magento\Composer\Installer\Mapping\MapCollection;

/**
 * Interface MappingInterface
 *
 * @category ${PROJECT_NAME}
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
interface ParserInterface
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
    public function isSupported(PackageInterface $package);

    /**
     * setPackage
     *
     * @param PackageInterface $package
     *
     * @return $this
     */
    public function setPackage(PackageInterface $package);

    /**
     * getMappings
     *
     * returns the resulting mappings as Collection
     *
     * @return MapCollection
     */
    public function getMappings();
}
