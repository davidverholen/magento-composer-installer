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

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use DavidVerholen\Magento\Composer\Installer\App\Di\ContainerFactory;
use DavidVerholen\Magento\Composer\Installer\Deploy\DeployService;
use Symfony\Component\DependencyInjection\Container;

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
     * @var DeployService
     */
    protected $deployService;

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
        ContainerFactory::init(
            static::APP_NAMESPACE,
            static::APP_NAME,
            static::APP_RES_DIR,
            static::APP_CONFIG_DIR,
            static::APP_SERVICE_MAIN_CONFIG,
            $composer,
            $io
        );
    }

    /**
     * getServiceContainer
     *
     * @return Container
     */
    public function getServiceContainer()
    {
        if (null === $this->container) {
            $this->container = ContainerFactory::getInstance()->build();
        }

        return $this->container;
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
