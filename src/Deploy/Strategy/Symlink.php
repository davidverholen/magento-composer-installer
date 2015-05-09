<?php
/**
 * Symlink.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy\Strategy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy\Strategy;

use DavidVerholen\Magento\Composer\Installer\Project\Config;

/**
 * Class Symlink
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy\Strategy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class Symlink extends AbstractStrategy
{
    /**
     * createDelegate
     *
     * @param string $src
     * @param string $dest
     *
     * @return void
     */
    protected function createDelegate($src, $dest)
    {
        $this->getFs()->symlink($src, $dest);
    }
}
