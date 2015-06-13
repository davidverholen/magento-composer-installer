<?php
/**
 * ModmanMapping.php
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
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ModmanMapping
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ModmanMapping extends AbstractMapping
{
    /**
     * @var string
     */
    protected $modmanFileName;

    /**
     * @var SplFileInfo
     */
    protected $modmanFile;

    /**
     * @return string
     */
    public function getModmanFileName()
    {
        return $this->modmanFileName;
    }

    /**
     * @param string $modmanFileName
     */
    public function setModmanFileName($modmanFileName)
    {
        $this->modmanFileName = $modmanFileName;
    }

    /**
     * isSupported
     *
     * checks if the mapping is supported by the package
     *
     * @param Package $package
     *
     * @return boolean
     */
    public function isSupported(Package $package)
    {
        return null !== $this->getModmanFile();
    }

    /**
     * getMappings
     *
     * returns the resulting mappings as array[source] = target
     *
     * @return array
     */
    public function getMappings()
    {
        $this->getModmanFile()->getContents();
        /** @todo get mappings from modman file */
        return [];
    }

    /**
     * getModmanFile
     *
     * @return SplFileInfo
     */
    public function getModmanFile()
    {
        if (null === $this->modmanFile) {
            $finder = $this->getFinder();
            $finder->in($this->getPackage()->getTargetDir());
            $finder->name($this->getModmanFileName());
            $finder->depth(0);
            $finder->files();

            foreach ($finder as $file) {
                $this->modmanFile = $file;
            }
        }

        return $this->modmanFile;
    }

    /**
     * getModmanFileLines
     *
     * @return array
     */
    public function getModmanFileLines()
    {
        return explode("\n", $this->getModmanFile()->getContents());
    }
}