<?php
/**
 * Service.php
 *
 * PHP Version 5
 *
 * @category Bragento_MagentoComposerInstaller
 * @package  Bragento_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy;

use DavidVerholen\Magento\Composer\Installer\App\AbstractService;
use DavidVerholen\Magento\Composer\Installer\Mapping\MappingService;
use Monolog\Logger;

/**
 * Class Service
 *
 * @category Bragento_MagentoComposerInstaller
 * @package  Deploy
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DeployService extends AbstractService
{
    /**
     * @var array
     */
    protected $packageTypes = array();

    /**
     * @var MappingService
     */
    protected $mappingService;

    /**
     * @param                $packageTypes
     * @param MappingService $mappingService
     */
    public function __construct(
        $packageTypes,
        MappingService $mappingService
    ) {
        $this->packageTypes = $packageTypes;
        $this->mappingService = $mappingService;
    }

    /**
     * getPackageTypes
     *
     * @return array
     */
    public function getPackageTypes()
    {
        return $this->packageTypes;
    }

    /**
     * getMappingService
     *
     * @return MappingService
     */
    public function getMappingService()
    {
        return $this->mappingService;
    }

    /**
     * deploy
     *
     * @return void
     */
    public function deploy()
    {
        /** @todo start deployment */
    }
}
