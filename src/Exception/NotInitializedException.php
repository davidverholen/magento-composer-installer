<?php
 /**
 * NotInitializedException.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Exception
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Exception;

use Exception;

/**
 * Class NotInitializedException
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Exception
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class NotInitializedException extends \Exception
{
    /**
     * @param mixed     $object
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($object, $code = 0, Exception $previous = null)
    {
        $message = sprintf('%s not initialized', get_class($object));
        parent::__construct($message, $code, $previous);
    }
}
