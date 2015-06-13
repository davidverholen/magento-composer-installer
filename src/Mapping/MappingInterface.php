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

namespace DavidVerholen\Magento\Composer\Installer\Mapping;

use Composer\Package\Package;

/**
 * Interface MappingInterface
 *
 * @category ${PROJECT_NAME}
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
interface MappingInterface
{
    /**
     * isSupported
     *
     * checks if the mapping is supported by the package
     *
     * @param Package $package
     *
     * @return boolean
     */
    public function isSupported(Package $package);

    /**
     * setPackage
     *
     * @param Package $package
     *
     * @return $this
     */
    public function setPackage(Package $package);

    /**
     * getMappings
     *
     * returns the resulting mappings as array[source] = target
     *
     * @return array
     */
    public function getMappings();
}