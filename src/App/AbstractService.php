<?php
/**
 * Base.php
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

use Monolog\Logger;

/**
 * Class Base
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Service
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class AbstractService
{
    /**
     * @todo pass logger output through to composer IOInterface
     *
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * getLogger
     *
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
