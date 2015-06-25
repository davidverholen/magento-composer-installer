<?php
/**
 * LoggerService.php
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
 * Class LoggerService
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  App
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class LoggerService
{
    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @param IOInterface $io
     */
    public function __construct(IOInterface $io)
    {
        $this->io = $io;
    }

    /**
     * log
     *
     * @param      $messages
     * @param bool $onlyInDebug
     * @param null $wrapper
     *
     * @return void
     */
    public function log(
        $messages,
        $onlyInDebug = false,
        $wrapper = null
    ) {
        if ($onlyInDebug && false === $this->io->isDebug()) {
            return;
        }

        $messages = is_array($messages) ? $messages : array($messages);
        $formatString = $wrapper !== null
            ? sprintf('<%1$s>%%s</%1$s>', $wrapper)
            : '%s';

        foreach ($messages as $message) {
            $this->io->write(sprintf($formatString, $message));
        }
    }
}
