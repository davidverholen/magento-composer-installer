<?php
/**
 * MappingTest.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   Bragento\Test\Magento\Composer\Installer\Mapping
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace Bragento\Test\Magento\Composer\Installer\Mapping;

use DavidVerholen\Magento\Composer\Installer\Mapping\Composer;
use DavidVerholen\Magento\Composer\Installer\Mapping\Factory;
use DavidVerholen\Magento\Composer\Installer\Mapping\Modman;

/**
 * Class MappingTest
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   Bragento\Test\Magento\Composer\Installer\Mapping
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class MappingTest extends AbstractMappingTest
{
    /**
     * @var Modman
     */
    protected $object;

    protected function getMappingName()
    {
        return 'global';
    }

    /**
     * testResolveMappings
     *
     * @param $mappings
     * @param $files
     * @param $expected
     *
     * @return void
     *
     * @dataProvider testMappingsDataProvider
     */
    public function testResolveMappings($mappings, $files, $expected)
    {
        $this->toBuildDir();
        $this->createTestFiles($files);

        $actual = $this->getTestObject()->resolveMappings($mappings);

        while (($act = each($actual)) !== false
            && ($exp = each($expected)) !== false) {
            $this->assertEquals($exp['key'], $act['key']);
            $this->assertEquals($exp['value'], $act['value']);
        }
    }

    public function testFactoryGetModmanMap()
    {
        $this->copyFiles('modman');

        $mapping = Factory::get(
            $this->getTestPackage(),
            $this->getBuildDir()
        );

        $this->assertInstanceOf(
            '\\Bragento\\Magento\\Composer\\Installer\\Mapping\\Modman',
            $mapping
        );
    }

    public function testFactoryGetPackageMap()
    {
        $this->copyFiles('package');

        $mapping = Factory::get(
            $this->getTestPackage(),
            $this->getBuildDir()
        );

        $this->assertInstanceOf(
            '\\Bragento\\Magento\\Composer\\Installer\\Mapping\\Package',
            $mapping
        );
    }

    public function testFactoryGetComposerMap()
    {
        $mapping = Factory::get(
            $this->getTestPackage(
                array(
                    Composer::COMPOSER_MAP_KEY => array(
                        array('test', 'test')
                    )
                )
            ),
            $this->getBuildDir()
        );

        $this->assertInstanceOf(
            '\\Bragento\\Magento\\Composer\\Installer\\Mapping\\Composer',
            $mapping
        );
    }

    /**
     * testMappingNotFound
     *
     * @return void
     *
     * @expectedException \Bragento\Magento\Composer\Installer\Mapping\Exception\MappingNotFoundException
     */
    public function testMappingNotFound()
    {
        Factory::get(
            $this->getTestPackage(),
            $this->getBuildDir()
        );
    }

    protected function copyFiles($name)
    {
        $dir = sprintf('files/mappings/global/%s', $name);
        $this->getFilesystem()->copy(
            $this->getTestResDir($dir),
            $this->getBuildDir()
        );
    }

    /**
     * getTestObject
     *
     * @return Modman
     */
    protected function getTestObject()
    {
        if (null === $this->object) {
            $this->object = new Modman(
                $this->getBuildDir(),
                $this->getTestPackage()
            );
        }

        return $this->object;
    }
}
