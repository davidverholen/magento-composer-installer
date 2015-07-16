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
     * StrategyFactory constructor.
     *
     * @param array $deployStrategyTypes
     */
    public function __construct(array $deployStrategyTypes)
    {
        $this->deployStrategyTypes = $deployStrategyTypes;
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
            $mappings
        );

        if (false === ($strategyClass instanceof AbstractStrategy)) {
            throw new InvalidDeployStrategyException($strategyClassName);
        }

        return $strategyClass;
    }
}
