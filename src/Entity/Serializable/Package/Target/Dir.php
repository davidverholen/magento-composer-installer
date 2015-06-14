<?php
 /**
 * Dir.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package\Target;

 /**
 * Class Dir
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package\Target
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Dir
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array<DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package\Target\Dir>
     */
    protected $dirs;

    /**
     * @var array<DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package\Target\File>
     */
    protected $files;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getDirs()
    {
        return $this->dirs;
    }

    /**
     * @param array $dirs
     */
    public function setDirs($dirs)
    {
        $this->dirs = $dirs;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }
}
