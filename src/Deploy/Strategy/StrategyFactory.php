<?php
/**
 * StrategyFactory.php
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

use Composer\Package\PackageInterface;
use DavidVerholen\Magento\Composer\Installer\App\AbstractService;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class StrategyFactory
 *
 * @category magento-composer-installer
 * @package  DavidVerholen\Magento\Composer\Installer\Deploy\Strategy
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class StrategyFactory extends AbstractService
{
    /**
     * @var array
     */
    protected $deployStrategyTypes = [];

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * StrategyFactory constructor.
     *
     * @param array      $deployStrategyTypes
     * @param Filesystem $filesystem
     */
    public function __construct(
        array $deployStrategyTypes,
        Filesystem $filesystem
    ) {
        $this->deployStrategyTypes = $deployStrategyTypes;
        $this->filesystem;
    }

    /**
     * createStrategy
     *
     * @param PackageInterface $package
     * @param                  $type
     * @param                  $mappings
     *
     * @return StrategyInterface
     * @throws InvalidDeployStrategyException
     */
    public function createStrategy(
        PackageInterface $package,
        $type,
        $mappings
    ) {
        return $this->getStrategyClass(
            $this->getDeployStrategyTypes()[$type],
            $package,
            $mappings
        );
    }

    /**
     * @return array
     */
    public function getDeployStrategyTypes()
    {
        return $this->deployStrategyTypes;
    }

    /**
     * @param array $deployStrategyTypes
     */
    public function setDeployStrategyTypes($deployStrategyTypes)
    {
        $this->deployStrategyTypes = $deployStrategyTypes;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param Filesystem $filesystem
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * getStrategyClass
     *
     * @param                  $strategyClassName
     * @param PackageInterface $package
     * @param                  $mappings
     *
     * @return StrategyInterface
     * @throws InvalidDeployStrategyException
     */
    protected function getStrategyClass(
        $strategyClassName,
        PackageInterface $package,
        $mappings
    ) {
        if (false === class_exists($strategyClassName)) {
            throw new InvalidDeployStrategyException($strategyClassName);
        }

        $strategyClass = new $strategyClassName(
            $package,
            $mappings,
            $this->getFilesystem()
        );

        if (false === ($strategyClass instanceof AbstractStrategy)) {
            throw new InvalidDeployStrategyException($strategyClassName);
        }

        return $strategyClass;
    }
}
