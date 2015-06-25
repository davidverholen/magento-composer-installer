<?php
 /**
 * LoggerFactory.php
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

use Composer\IO\IOInterface;

/**
 * Class LoggerFactory
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  App
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class LoggerFactory
{
    /**
     * @var IOInterface
     */
    protected static $io;

    /**
     * createLogger
     *
     * @return LoggerService
     * @throws \Exception
     */
    public static function createLogger()
    {
        if (null === self::$io) {
            throw new \Exception('No IOInterface set for Logger Factory');
        }

        return new LoggerService(self::$io);
    }

    /**
     * @param IOInterface $io
     */
    public static function setIo($io)
    {
        self::$io = $io;
    }
}
