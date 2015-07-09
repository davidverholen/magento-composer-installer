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

namespace DavidVerholen\Magento\Composer\Installer\Mapping;

use Composer\Package\PackageInterface;

/**
 * Class DefaultMapping
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DefaultMapping extends AbstractMapping
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
     * returns the resulting mappings as array[source] = target
     *
     * @return array
     */
    public function getMappings()
    {
        return ['.' => '.'];
    }
}
