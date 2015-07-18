<?php
/**
 * Copy.php
 *
 * PHP Version 5
 *
 * @category magento-composer-installer
 * @package  magento-composer-installer
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy\Strategy;

use Exception;

/**
 * Class Copy
 *
 * @category magento-composer-installer
 * @package  DavidVerholen\Magento\Composer\Installer\Deploy\Strategy
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Copy extends AbstractStrategy
{

    /**
     * createDelegate
     *
     * @param $source
     * @param $target
     *
     * @return boolean
     */
    protected function createDelegate($source, $target)
    {
        try {
            $this->validateFile($source);

            if (is_file($source)) {
                $this->getFilesystem()->copy($source, $target);
            } elseif (is_dir($source)) {
                $this->getFilesystem()->mirror($source, $target);
            }

            $this->validateFile($target);
        } catch (Exception $e) {
            $this->addError($e->getMessage());
            return false;
        }

        return true;
    }
}
