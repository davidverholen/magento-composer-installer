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
     * @var array
     */
    protected $ignoreLinesCharacters;

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
     * @return array
     */
    public function getIgnoreLinesCharacters()
    {
        return $this->ignoreLinesCharacters;
    }

    /**
     * @param array $ignoreLinesCharacters
     */
    public function setIgnoreLinesCharacters($ignoreLinesCharacters)
    {
        $this->ignoreLinesCharacters = $ignoreLinesCharacters;
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
        $map = [];
        foreach ($this->getFileLines($this->getModmanFile()) as $line) {
            $firstChar = substr(trim($line), 0, 1);
            if (!in_array($firstChar, $this->getIgnoreLinesCharacters())) {
                $lineParts = explode(' ', trim($line));
                $map[trim($lineParts[0])] = trim($lineParts[1]);
            }
        }

        return $map;
    }

    /**
     * getModmanFile
     *
     * @return SplFileInfo
     */
    public function getModmanFile()
    {
        return $this->getRootDirFile($this->getModmanFileName());
    }
}
