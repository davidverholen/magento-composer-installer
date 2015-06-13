<?php
/**
 * MappingFactory.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Mapping;

use Composer\Package\Package;
use DavidVerholen\Magento\Composer\Installer\App\AbstractService;

/**
 * Class MappingFactory
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class MappingService extends AbstractService
{
    /**
     * @var MappingInterface[]
     */
    protected $mappings;

    /**
     * @var MappingInterface
     */
    protected $defaultMapping;

    /**
     * @var ResolverService
     */
    protected $resolverService;

    /**
     * @param MappingInterface $defaultMapping
     * @param ResolverService  $resolverService
     */
    public function __construct(
        MappingInterface $defaultMapping,
        ResolverService $resolverService
    ) {
        $this->defaultMapping = $defaultMapping;
        $this->resolverService = $resolverService;
        $this->mappings = array();
    }

    /**
     * getMappings
     *
     * @param Package $package
     *
     * @return array
     */
    public function getMappings(Package $package)
    {
        return $this->getResolverService()->resolve($this->createMapping($package));
    }

    /**
     * createMapping
     *
     * @param Package $package
     *
     * @return MappingInterface
     */
    protected function createMapping(Package $package)
    {
        foreach ($this->mappings as $mapping) {
            if ($mapping->isSupported($package)) {
                return $mapping->setPackage($package);
            }
        }

        return $this->defaultMapping->setPackage($package);
    }

    /**
     * getResolverService
     *
     * @return ResolverService
     */
    protected function getResolverService()
    {
        return $this->resolverService;
    }

    /**
     * addMapping
     *
     * @param MappingInterface $mapping
     *
     * @return void
     */
    public function addMapping(MappingInterface $mapping)
    {
        $this->mappings[] = $mapping;
    }
}
