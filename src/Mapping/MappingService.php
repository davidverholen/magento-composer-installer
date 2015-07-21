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

use Composer\Package\PackageInterface;
use DavidVerholen\Magento\Composer\Installer\App\AbstractService;
use DavidVerholen\Magento\Composer\Installer\Mapping\Parser\ParserInterface;

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
     * @var ParserInterface[]
     */
    protected $mappings;

    /**
     * @var ParserInterface
     */
    protected $defaultParser;

    /**
     * @var ResolverService
     */
    protected $resolverService;

    /**
     * @param ParserInterface $defaultParser
     * @param ResolverService $resolverService
     */
    public function __construct(
        ParserInterface $defaultParser,
        ResolverService $resolverService
    ) {
        $this->defaultParser = $defaultParser;
        $this->resolverService = $resolverService;
        $this->mappings = [];
    }

    /**
     * getMappings
     *
     * @param PackageInterface $package
     *
     * @return MapCollection
     */
    public function getMappings(PackageInterface $package)
    {
        return $this->getResolverService()->resolve($this->createMapping($package));
    }

    /**
     * createMapping
     *
     * @param PackageInterface $package
     *
     * @return ParserInterface
     */
    protected function createMapping(PackageInterface $package)
    {
        foreach ($this->mappings as $mapping) {
            if ($mapping->isSupported($package)) {
                return $mapping->setPackage($package);
            }
        }

        return $this->defaultParser->setPackage($package);
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
     * @param ParserInterface $parser
     *
     * @return void
     */
    public function addParser(ParserInterface $parser)
    {
        $this->mappings[] = $parser;
    }
}
