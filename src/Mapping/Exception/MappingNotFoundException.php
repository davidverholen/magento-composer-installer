<?php
/**
 * MappingNotFoundException.php
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

use Composer\Package\PackageInterface;
use Exception;

/**
 * Class MappingNotFoundException
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Mapping\Exception
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class MappingNotFoundException extends MappingException
{
    /**
     * @param PackageInterface $package
     * @param int              $code
     * @param Exception        $previous
     */
    public function __construct(
        PackageInterface $package,
        $code = 0,
        Exception $previous = null
    ) {
        $message = sprintf(
            'mapping for package %s not found',
            $package->getName()
        );
        parent::__construct($message, $code, $previous);
    }
}
