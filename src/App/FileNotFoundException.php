<?php
/**
 * FileNotFoundException.php
 *
 * PHP Version 5
 *
 * @category magento-composer-installer
 * @package  magento-composer-installer
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\App;

use Exception;

/**
 * Class FileNotFoundException
 *
 * @category magento-composer-installer
 * @package  DavidVerholen\Magento\Composer\Installer\App
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class FileNotFoundException extends \Exception
{
    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @link http://php.net/manual/en/exception.construct.php
     *
     * @param string    $filename  [optional] The Exception message to throw.
     * @param int       $code     [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct(
        $filename,
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct(sprintf(
            'file not found: %s', $filename),
            $code,
            $previous
        );
    }
}
