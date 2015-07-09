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

use Composer\Composer;
use Composer\Package\Package;
use DavidVerholen\Magento\Composer\Installer\App\AbstractService;
use DavidVerholen\Magento\Composer\Installer\Mapping\MappingService;

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
     * @var Composer
     */
    protected $composer;

    /**
     * @param                $packageTypes
     * @param MappingService $mappingService
     * @param Composer       $composer
     */
    public function __construct(
        $packageTypes,
        MappingService $mappingService,
        Composer $composer
    ) {
        $this->packageTypes = $packageTypes;
        $this->mappingService = $mappingService;
        $this->composer = $composer;
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
     * @return \Composer\Package\PackageInterface[]
     */
    public function getPackages()
    {
        return $this->getComposer()
            ->getRepositoryManager()
            ->getLocalRepository()
            ->getCanonicalPackages();
    }

    /**
     * @return Composer
     */
    public function getComposer()
    {
        return $this->composer;
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
