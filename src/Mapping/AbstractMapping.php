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
use Symfony\Component\Finder\SplFileInfo;

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

    /**
     * getFileLines
     *
     * @param SplFileInfo $file
     *
     * @return array
     */
    public function getFileLines(SplFileInfo $file)
    {
        return explode("\n", $file->getContents());
    }

    /**
     * getPackageFile
     *
     * @param string $filename
     *
     * @return SplFileInfo
     */
    public function getRootDirFile($filename)
    {
        $finder = $this->getFinder()
            ->create()
            ->in($this->getPackage()->getTargetDir())
            ->name($filename)
            ->depth(0)
            ->files();

        foreach ($finder as $file) {
            return $file;
        }

        return null;
    }
}
