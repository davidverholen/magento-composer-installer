<?php
/**
 * UnknownPathtypeException.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Mapping\Exception
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Mapping\Exception;

use Exception;

/**
 * Class UnknownPathtypeException
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Mapping\Exception
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class UnknownPathtypeException extends \Exception
{
    /**
     * @param string    $pathtype
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct(
        $pathtype,
        $code = 0,
        Exception $previous = null
    ) {
        $message = sprintf('unknown path type: %s', $pathtype);
        parent::__construct($message, $code, $previous);
    }
}
