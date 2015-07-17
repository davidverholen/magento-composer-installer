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

namespace DavidVerholen\Magento\Composer\Installer\Mapping\Parser;

use Composer\Package\PackageInterface;
use DavidVerholen\Magento\Composer\Installer\Mapping\MapCollection;
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
abstract class AbstractParser implements ParserInterface
{
    /**
     * @var PackageInterface
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
     * @var MapCollection
     */
    private $mapCollection;

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

        $this->mapCollection = new MapCollection();
    }

    /**
     * setPackage
     *
     * @param PackageInterface $package
     *
     * @return $this
     */
    public function setPackage(PackageInterface $package)
    {
        $this->package = $package;
        return $this;
    }

    /**
     * getPackage
     *
     * @return PackageInterface
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

    /**
     * @return MapCollection
     */
    public function getMapCollection()
    {
        return $this->mapCollection;
    }
}
