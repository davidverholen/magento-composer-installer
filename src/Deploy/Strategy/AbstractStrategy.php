<?php
/**
 * AbstractStrategy.php
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
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class AbstractStrategy
 *
 * @category magento-composer-installer
 * @package  ${NAMESPACE}
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * @var array
     */
    protected $mappings;

    /**
     * @var PackageInterface
     */
    protected $package;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * AbstractStrategy constructor.
     *
     * @param PackageInterface $package
     * @param array            $mappings
     * @param Filesystem       $filesystem
     */
    public function __construct(
        PackageInterface $package,
        array $mappings,
        Filesystem $filesystem
    ) {
        $this->mappings = $mappings;
        $this->package = $package;
        $this->filesystem = $filesystem;
    }

    /**
     * deploy
     *
     * @return void
     */
    public function deploy()
    {
        foreach ($this->getMappings() as $mapping) {
            $this->createDelegate($mapping[0], $mapping[1]);
        }
    }

    /**
     * createDelegate
     *
     * @param $source
     * @param $target
     *
     * @return mixed
     */
    abstract protected function createDelegate($source, $target);

    /**
     * @return array
     */
    public function getMappings()
    {
        return $this->mappings;
    }

    /**
     * @param array $mappings
     */
    public function setMappings($mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * @return PackageInterface
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param PackageInterface $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
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
}
