<?php
/**
 * Entry.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy\Manager;

use DavidVerholen\Magento\Composer\Installer\Deploy\Strategy\AbstractStrategy;
use DavidVerholen\Magento\Composer\Installer\Deploy\Strategy;

/**
 * Class Entry
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class Entry
{
    /**
     * deployStrategy
     *
     * @var AbstractStrategy
     */
    protected $deployStrategy;

    /**
     * entry constructor
     *
     * @param Strategy\AbstractStrategy $deployStrategy deploy strategy
     */
    public function __construct(
        AbstractStrategy $deployStrategy
    ) {
        $this->deployStrategy = $deployStrategy;
    }

    /**
     * DeployStrategy
     *
     * @return AbstractStrategy
     */
    public function getDeployStrategy()
    {
        return $this->deployStrategy;
    }
}
