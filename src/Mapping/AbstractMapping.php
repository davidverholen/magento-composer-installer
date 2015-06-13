<?php
/**
 * AbstractMapping.php
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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class AbstractMapping
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class AbstractMapping implements MappingInterface
{
    /**
     * @var Package
     */
    private $package;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @param Filesystem $filesystem
     * @param Finder     $finder
     */
    public function __construct(
        Filesystem $filesystem,
        Finder $finder
    ) {
        $this->filesystem = $filesystem;
        $this->finder = $finder;
    }

    /**
     * setPackage
     *
     * @param Package $package
     *
     * @return $this
     */
    public function setPackage(Package $package)
    {
        $this->package = $package;
        return $this;
    }

    /**
     * getPackage
     *
     * @return Package
     */
    protected function getPackage()
    {
        return $this->package;
    }

    /**
     * getFilesystem
     *
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * getFinder
     *
     * @return Finder
     */
    protected function getFinder()
    {
        return $this->finder;
    }
}
