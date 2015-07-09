<?php
/**
 * Plugin.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer;

use DavidVerholen\Magento\Composer\Installer\App\LoggerFactory;
use DavidVerholen\Magento\Composer\Installer\App\SerializerFactory;
use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use DavidVerholen\Magento\Composer\Installer\Deploy\DeployService;
use JMS\Serializer\Serializer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class Plugin
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{
    const APP_NAMESPACE = 'davidverholen';
    const APP_NAME = 'magento-composer-installer';

    const APP_RES_DIR = 'res';
    const APP_CONFIG_DIR = 'config';
    const APP_SERVICE_MAIN_CONFIG = 'services.xml';

    /**
     * @var string
     */
    protected $serviceConfigDir;

    /**
     * @var DeployService
     */
    protected $deployService;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     * * The method name to call (priority defaults to 0)
     * * An array composed of the method name to call and the priority
     * * An array of arrays composed of the method names to call and respective
     *   priorities, or 0 if unset
     *
     * For instance:
     *
     * * array('eventName' => 'methodName')
     * * array('eventName' => array('methodName', $priority))
     * * array('eventName' => array(array(
     * *    'methodName1',
     * *    $priority
     * *), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            ScriptEvents::POST_INSTALL_CMD => 'deployPackages',
            ScriptEvents::POST_UPDATE_CMD  => 'deployPackages'
        );
    }

    /**
     * Apply plugin modifications to composer
     *
     * @param Composer    $composer Composer Instance
     * @param IOInterface $io       IO Interface
     *
     * @return void
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->initServiceContainer($composer, $io);
    }

    /**
     * initServiceContainer
     *
     * @param Composer    $composer
     *
     * @param IOInterface $io
     */
    private function initServiceContainer(Composer $composer, IOInterface $io)
    {
        $this->container = new ContainerBuilder();
        $loader = new XmlFileLoader(
            $this->container,
            new FileLocator($this->getServiceConfigDir($composer))
        );
        $loader->load(self::APP_SERVICE_MAIN_CONFIG);

        $this->container->set('composer', $composer);
        $this->container->set('io', $io);
        $this->container->set('plugin', $this);

        $this->container->compile();
    }

    /**
     * getServiceContainer
     *
     * @return Container
     */
    public function getServiceContainer()
    {
        return $this->container;
    }

    /**
     * getApplicationDir
     *
     * @param Composer    $composer
     *
     * @return string
     */
    public function getApplicationDir(Composer $composer)
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                realpath($composer->getConfig()->get('vendor-dir')),
                self::APP_NAMESPACE,
                self::APP_NAME
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
     * @param Composer    $composer
     *
     * @return string
     */
    public function getServiceConfigDir(Composer $composer)
    {
        if (null === $this->serviceConfigDir) {
            $this->serviceConfigDir = implode(
                DIRECTORY_SEPARATOR,
                [
                    $this->getApplicationDir($composer),
                    self::APP_RES_DIR,
                    self::APP_CONFIG_DIR
                ]
            );
        }

        return $this->serviceConfigDir;
    }

    /**
     * getDeployService
     *
     * @return DeployService|object
     */
    protected function getDeployService()
    {
        if (null === $this->deployService) {
            $this->deployService = $this->getServiceContainer()
                ->get('deployService');
        }

        return $this->deployService;
    }

    /**
     * onPostInstallCmd
     *
     * @param Event $event
     *
     */
    public function deployPackages(Event $event)
    {
        $this->getDeployService()->deploy();
    }
}
