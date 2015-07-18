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
use Composer\Package\PackageInterface;
use DavidVerholen\Magento\Composer\Installer\App\AbstractService;
use DavidVerholen\Magento\Composer\Installer\Deploy\Strategy\StrategyFactory;
use DavidVerholen\Magento\Composer\Installer\Mapping\MappingService;
use Symfony\Component\Filesystem\Filesystem;

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
    protected $packageTypes = [];

    /**
     * @var MappingService
     */
    protected $mappingService;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var StrategyFactory
     */
    protected $strategyFactory;

    /**
     * @param                 $packageTypes
     * @param MappingService  $mappingService
     * @param Composer        $composer
     * @param Filesystem      $filesystem
     * @param StrategyFactory $strategyFactory
     */
    public function __construct(
        $packageTypes,
        MappingService $mappingService,
        Composer $composer,
        Filesystem $filesystem,
        StrategyFactory $strategyFactory
    ) {
        $this->packageTypes = $packageTypes;
        $this->mappingService = $mappingService;
        $this->composer = $composer;
        $this->filesystem = $filesystem;
        $this->strategyFactory = $strategyFactory;
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
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * deploy
     *
     * @return void
     */
    public function deploy()
    {
        /** @var PackageInterface $package */
        foreach ($this->getPackages() as $package) {
            $this->getStrategyFactory()->createStrategy(
                $package,
                'copy',
                $this->getMappingService()->getMappings($package)
            )->deploy();
        }
    }

    /**
     * @return StrategyFactory
     */
    public function getStrategyFactory()
    {
        return $this->strategyFactory;
    }

    /**
     * @param StrategyFactory $strategyFactory
     */
    public function setStrategyFactory($strategyFactory)
    {
        $this->strategyFactory = $strategyFactory;
    }
}
