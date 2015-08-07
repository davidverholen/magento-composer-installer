<?php
/**
 * PluginTest.php
 *
 * PHP Version 5
 *
 * @category Bragento_MagentoComposerInstaller
 * @package  Bragento_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer;

use Composer\Config;
use Composer\Package\Package;
use DavidVerholen\Magento\Composer\Installer\App\Di\ContainerFactory;
use DavidVerholen\Magento\Composer\Installer\Deploy\DeployService;
use DavidVerholen\Magento\Composer\Installer\Mapping\Map;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class PluginTest
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  ${NAMESPACE}
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class PluginTest extends AbstractTest
{
    /** @var Plugin */
    protected $subject;

    protected function setUp()
    {
        $this->subject = new Plugin();
        $this->subject->activate($this->getComposer(), $this->getIo());
        ContainerFactory::getInstance()->setServiceConfigDir($this->getTestServiceConfigDir());

        parent::setUp();
    }

    public function testGetServiceContainer()
    {
        $this->assertInstanceOf(
            'Symfony\Component\DependencyInjection\Container',
            $this->subject->getServiceContainer()
        );
    }

    public function testGetDeployService()
    {
        $this->assertInstanceOf(
            'DavidVerholen\Magento\Composer\Installer\Deploy\DeployService',
            $this->subject->getServiceContainer()->get('deployService')
        );
    }

    public function testGetPackageTypes()
    {
        /** @var DeployService $deployService */
        $deployService = $this->subject->getServiceContainer()
            ->get('deployService');

        $this->assertEquals(
            ['magento-module', 'magento-core'],
            $deployService->getPackageTypes()
        );
    }

    public function testComposerMapInFullApplication()
    {
        /** @var DeployService $deployService */
        $deployService = $this->subject->getServiceContainer()
            ->get('deployService');
        $mappingService = $deployService->getMappingService();

        $package = new Package('test', '1.0.0', '1.0.0');
        $package->setExtra(['map' => [['test', 'test']]]);
        $mappings = $mappingService->getMappings($package);

        /** @var Map $map */
        foreach ($mappings as $map) {
            $this->assertEquals('test', $map->getSource());
            $this->assertEquals('test', $map->getTarget());
        }
    }

    public function testGetModmanFileName()
    {

    }
}
