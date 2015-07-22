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
use DavidVerholen\Magento\Composer\Installer\App\ConfigService;
use DavidVerholen\Magento\Composer\Installer\App\FileNotFoundException;
use DavidVerholen\Magento\Composer\Installer\Mapping\Map;
use DavidVerholen\Magento\Composer\Installer\Mapping\MapCollection;
use Exception;
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
     * @var ConfigService
     */
    private $config;

    /**
     * @var array
     */
    private $errors;

    /**
     * AbstractStrategy constructor.
     *
     * @param PackageInterface $package
     * @param MapCollection    $mapCollection
     * @param Filesystem       $filesystem
     * @param ConfigService    $config
     */
    public function __construct(
        PackageInterface $package,
        MapCollection $mapCollection,
        Filesystem $filesystem,
        ConfigService $config
    ) {
        $this->mappings = $mapCollection;
        $this->package = $package;
        $this->filesystem = $filesystem;
        $this->config = $config;

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
        foreach ($this->getMapCollection() as $map) {
            try {
                $this->validateFile($map->getSource());
                $this->createDelegate($map);
                $this->validateFile($map->getTarget());
            } catch (Exception $e) {
                $this->addError($e->getMessage());
            }
        }
    }

    /**
     * createDelegate
     *
     * @param Map $map
     *
     * @return void
     */
    abstract protected function createDelegate(Map $map);

    /**
     * validateSource
     *
     * @param string $path
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
     * getSourceBasePath
     *
     * @return string
     */
    protected function getSourceBasePath()
    {
        return realpath($this->getPackage()->getTargetDir());
    }

    /**
     * getTargetBasePath
     *
     * @return string
     */
    protected function getTargetBasePath()
    {
        return realpath($this->getConfig()->getReleaseDir());
    }

    /**
     * getFullSourcePath
     *
     * @param $relativeSource
     *
     * @return string
     */
    protected function getFullSourcePath($relativeSource)
    {
        return $this->joinPath($this->getSourceBasePath(), $relativeSource);
    }

    /**
     * getFullTargetPath
     *
     * @param $relativeTarget
     *
     * @return string
     */
    protected function getFullTargetPath($relativeTarget)
    {
        return $this->joinPath($this->getTargetBasePath(), $relativeTarget);
    }

    /**
     * joinPath
     *
     * @param $base
     * @param $relativePath
     *
     * @return string
     */
    protected function joinPath($base, $relativePath)
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [$base, $relativePath]
        );
    }

    /**
     * @return MapCollection
     */
    public function getMapCollection()
    {
        return $this->mappings;
    }

    /**
     * @param MapCollection $mappings
     */
    public function setMapCollection($mappings)
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
     * @return ConfigService
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * addError
     *
     * @param string $message
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
