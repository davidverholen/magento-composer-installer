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
     * @var LoggerService
     */
    private $logger;

    /**
     * @var ConfigService
     */
    private $config;

    /**
     * @param LoggerService $logger
     * @param ConfigService $config
     */
    public function setLogger(
        LoggerService $logger,
        ConfigService $config
    ) {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * getLogger
     *
     * @return LoggerService
     */
    protected function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return ConfigService
     */
    protected function getConfig()
    {
        return $this->config;
    }
}
