<?php
 /**
 * TestApplication.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   Bragento\Test\Magento\Composer\Installer
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace Bragento\Test\Magento\Composer\Installer;

use Composer\Console\Application;
use Composer\IO\IOInterface;

/**
 * Class TestApplication
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   Bragento\Test\Magento\Composer\Installer
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class TestApplication extends Application
{
    public function setIo(IOInterface $io)
    {
        $this->io = $io;
    }
}
