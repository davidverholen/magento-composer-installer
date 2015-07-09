<?php
/**
 * PackageMapping.php
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
use DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package\Target;
use JMS\Serializer\Serializer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class PackageMapping
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class PackageMapping extends AbstractMapping
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var array
     */
    protected $packageTargets;

    /**
     * @var string
     */
    protected $packageFileName;

    /**
     * @var SplFileInfo
     */
    protected $packageFile;

    /**
     * @var string
     */
    protected $packageEntityClass;

    /**
     * @var string
     */
    protected $serializeFormat;

    /**
     * @param Filesystem $filesystem
     * @param Finder     $finder
     * @param Serializer $serializer
     */
    public function __construct(
        Filesystem $filesystem,
        Finder $finder,
        Serializer $serializer
    ) {
        parent::__construct(
            $filesystem,
            $finder
        );

        $this->serializer = $serializer;
    }

    /**
     * isSupported
     *
     * checks if the mapping is supported by the package
     *
     * @param PackageInterface $package
     *
     * @return boolean
     */
    public function isSupported(PackageInterface $package)
    {
        return null !== $this->getPackageFile();
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
        /** @var Target $target */
        foreach($this->getPackageEntity()->getContents() as $target) {

        }
        // TODO: Implement getMappings() method.
    }

    /**
     * getPackageFile
     *
     * @return SplFileInfo
     */
    public function getPackageFile()
    {
        return $this->getRootDirFile($this->getPackageFileName());
    }

    /**
     * @return string
     */
    public function getPackageXml()
    {
        return $this->getPackageFile()->getContents();
    }

    /**
     * @return \DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package
     */
    public function getPackageEntity()
    {
        return $this->getSerializer()->deserialize(
            $this->getPackageXml(),
            $this->getPackageEntityClass(),
            $this->getSerializeFormat()
        );
    }

    /**
     * @return string
     */
    public function getSerializeFormat()
    {
        return $this->serializeFormat;
    }

    /**
     * @param string $serializeFormat
     */
    public function setSerializeFormat($serializeFormat)
    {
        $this->serializeFormat = $serializeFormat;
    }

    /**
     * @return string
     */
    public function getPackageEntityClass()
    {
        return $this->packageEntityClass;
    }

    /**
     * @param string $packageEntityClass
     */
    public function setPackageEntityClass($packageEntityClass)
    {
        $this->packageEntityClass = $packageEntityClass;
    }

    /**
     * @return string
     */
    public function getPackageFileName()
    {
        return $this->packageFileName;
    }

    /**
     * @param string $packageFileName
     */
    public function setPackageFileName($packageFileName)
    {
        $this->packageFileName = $packageFileName;
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @param Serializer $serializer
     */
    public function setSerializer($serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public function getPackageTargets()
    {
        return $this->packageTargets;
    }

    /**
     * @param array $packageTargets
     */
    public function setPackageTargets($packageTargets)
    {
        $this->packageTargets = $packageTargets;
    }
}
