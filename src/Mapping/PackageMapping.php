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

use Composer\Package\Package;
use JMS\Serializer\Serializer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

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
     * @param Package $package
     *
     * @return boolean
     */
    public function isSupported(Package $package)
    {
        // TODO: Implement isSupported() method.
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
        // TODO: Implement getMappings() method.
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
