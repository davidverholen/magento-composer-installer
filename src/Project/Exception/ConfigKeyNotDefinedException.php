<?php
/**
 * RequiredConfigKeyNotDefinedException.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Project
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Project\Exception;

use Exception;

/**
 * Class RequiredConfigKeyNotDefinedException
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Project
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class ConfigKeyNotDefinedException extends \Exception
{
    /**
     * @param string    $key
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($key, $code = 0, Exception $previous = null)
    {
        $message = sprintf('required config key %s not defined', $key);
        parent::__construct($message, $code, $previous);
    }
}
