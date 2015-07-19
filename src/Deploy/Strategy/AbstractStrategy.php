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
use DavidVerholen\Magento\Composer\Installer\App\FileNotFoundException;
use DavidVerholen\Magento\Composer\Installer\Mapping\Map;
use DavidVerholen\Magento\Composer\Installer\Mapping\MapCollection;
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
     * @var MapCollection
     */
    private $mappings;

    /**
     * @var PackageInterface
     */
    private $package;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var array
     */
    private $errors;

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

        $this->errors = [];
    }

    /**
     * deploy
     *
     * @return void
     */
    public function deploy()
    {
        /** @var Map $map */
        foreach ($this->getMappings() as $map) {
            $this->createDelegate($map);
        }
    }

    /**
     * createDelegate
     *
     * @param Map $map
     *
     * @return boolean
     */
    abstract protected function createDelegate(Map $map);

    /**
     * validateSource
     *
     * @param $path
     *
     * @return void
     * @throws FileNotFoundException
     */
    protected function validateFile($path)
    {
        if (false === $this->getFilesystem()->exists($path)) {
            throw new FileNotFoundException($path);
        }
    }

    /**
     * @return MapCollection
     */
    public function getMappings()
    {
        return $this->mappings;
    }

    /**
     * @param MapCollection $mappings
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

    /**
     * addError
     *
     * @param $message
     *
     * @return void
     */
    protected function addError($message)
    {
        $this->errors[] = $message;
    }

    /**
     * getErrors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * hasErrors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
}
