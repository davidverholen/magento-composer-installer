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

use DavidVerholen\Magento\Composer\Installer\Mapping\Map;
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
     * @param Map $map
     *
     * @return bool
     */
    protected function createDelegate(Map $map)
    {
        try {
            $this->validateFile($map->getSource());

            if (is_file($map->getSource())) {
                $this->getFilesystem()->copy(
                    $map->getSource(),
                    $map->getTarget()
                );
            } elseif (is_dir($map->getSource())) {
                $this->getFilesystem()->mirror(
                    $map->getSource(),
                    $map->getTarget()
                );
            }

            $this->validateFile($map->getTarget());
        } catch (Exception $e) {
            $this->addError($e->getMessage());
            return false;
        }

        return true;
    }
}
