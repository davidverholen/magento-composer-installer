<?php
/**
 * ContainerFactory.php
 *
 * PHP Version 5
 *
 * @category magento-composer-installer
 * @package  magento-composer-installer
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\App\Di;

use Composer\Composer;
use Composer\IO\IOInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class ContainerFactory
 *
 * @category magento-composer-installer
 * @package  DavidVerholen\Magento\Composer\Installer\App\Di
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ContainerFactory
{
    /**
     * @var ContainerFactory
     */
    private static $instance;

    /**
     * @var string
     */
    private $serviceConfigDir;

    /**
     * @var string
     */
    private $appNamespace;

    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    private $appResDir;

    /**
     * @var string
     */
    private $appConfigDir;

    /**
     * @var string
     */
    private $serviceConfig;

    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var IOInterface
     */
    private $io;

    /**
     * ContainerFactory constructor.
     *
     * @param string      $appNamespace
     * @param string      $appName
     * @param string      $appResDir
     * @param string      $appConfigDir
     * @param             $serviceConfig
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function __construct(
        $appNamespace,
        $appName,
        $appResDir,
        $appConfigDir,
        $serviceConfig,
        Composer $composer,
        IOInterface $io
    ) {
        $this->appNamespace = $appNamespace;
        $this->appName = $appName;
        $this->appResDir = $appResDir;
        $this->appConfigDir = $appConfigDir;
        $this->serviceConfig = $serviceConfig;
        $this->composer = $composer;
        $this->io = $io;

    }

    /**
     * create
     *
     * @param             $appNamespace
     * @param             $appName
     * @param             $appResDir
     * @param             $appConfigDir
     * @param             $serviceConfig
     * @param Composer    $composer
     * @param IOInterface $io
     *
     * @return void
     */
    public static function init(
        $appNamespace,
        $appName,
        $appResDir,
        $appConfigDir,
        $serviceConfig,
        Composer $composer,
        IOInterface $io
    ) {
        if (null === static::$instance) {
            static::$instance = new static(
                $appNamespace,
                $appName,
                $appResDir,
                $appConfigDir,
                $serviceConfig,
                $composer,
                $io
            );
        }
    }

    /**
     * getInstance
     *
     * @return ContainerFactory
     */
    public static function getInstance()
    {
        return static::$instance;
    }

    /**
     * build
     *
     * @return ContainerInterface
     */
    public function build()
    {
        $container = new ContainerBuilder();
        $loader = new XmlFileLoader(
            $container,
            new FileLocator($this->getServiceConfigDir())
        );
        $loader->load($this->serviceConfig);

        $container->set('composer', $this->composer);
        $container->set('io', $this->io);
        $container->set('plugin', $this);

        $container->compile();

        return $container;

    }

    /**
     * getApplicationDir
     *
     * @return string
     *
     */
    public function getApplicationDir()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                realpath($this->composer->getConfig()->get('vendor-dir')),
                $this->appNamespace,
                $this->appName
            ]
        );
    }

    /**
     * setServiceConfigDir
     *
     * @param string $serviceConfigDir
     *
     * @return void
     */
    public function setServiceConfigDir($serviceConfigDir)
    {
        $this->serviceConfigDir = $serviceConfigDir;
    }

    /**
     * getServiceConfigFilePath
     *
     * @return string
     */
    public function getServiceConfigDir()
    {
        if (null === $this->serviceConfigDir) {
            $this->serviceConfigDir = implode(
                DIRECTORY_SEPARATOR,
                [
                    $this->getApplicationDir(),
                    $this->appResDir,
                    $this->appConfigDir
                ]
            );
        }

        return $this->serviceConfigDir;
    }

    /**
     * @return string
     */
    public function getAppNamespace()
    {
        return $this->appNamespace;
    }

    /**
     * @param string $appNamespace
     */
    public function setAppNamespace($appNamespace)
    {
        $this->appNamespace = $appNamespace;
    }

    /**
     * @return string
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * @param string $appName
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
    }

    /**
     * @return string
     */
    public function getAppResDir()
    {
        return $this->appResDir;
    }

    /**
     * @param string $appResDir
     */
    public function setAppResDir($appResDir)
    {
        $this->appResDir = $appResDir;
    }

    /**
     * @return string
     */
    public function getAppConfigDir()
    {
        return $this->appConfigDir;
    }

    /**
     * @param string $appConfigDir
     */
    public function setAppConfigDir($appConfigDir)
    {
        $this->appConfigDir = $appConfigDir;
    }

    /**
     * @return string
     */
    public function getServiceConfig()
    {
        return $this->serviceConfig;
    }

    /**
     * @param string $serviceConfig
     */
    public function setServiceConfig($serviceConfig)
    {
        $this->serviceConfig = $serviceConfig;
    }

    /**
     * @return Composer
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * @param Composer $composer
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;
    }

    /**
     * @return IOInterface
     */
    public function getIo()
    {
        return $this->io;
    }

    /**
     * @param IOInterface $io
     */
    public function setIo($io)
    {
        $this->io = $io;
    }
}
