<?php
/**
 * ModmanMappingTest.php
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

use DavidVerholen\Magento\Composer\Installer\AbstractTest;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class ModmanMappingTest
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ModmanMappingTest extends AbstractTest
{
    const MODMAN = 'modman';

    /** @var ModmanMapping */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new ModmanMapping(
            new Filesystem(),
            new Finder()
        );

        $this->subject->setModmanFileName(self::MODMAN);
        $this->subject->setPackage($this->getDummyPackage());
    }

    /**
     * getModmanFilePath
     *
     * @return string
     */
    protected function getModmanFilePath()
    {
        return vfsStream::url('root/modman');
    }

    /**
     * createDummyModmanFile
     *
     * @param array $data
     */
    protected function createDummyModmanFile(array $data)
    {
        file_put_contents(
            $this->getModmanFilePath(),
            implode("\n", array_map(function ($key, $value) {
                return implode(' ', [$key, $value]);
            }, array_keys($data), array_values($data)))
        );
    }

    /**
     * modmanFileDataProvider
     *
     * @return array
     */
    public function modmanFileDataProvider()
    {
        return [
            [
                [
                    'app/etc/modules/*'           => 'app/etc/modules/',
                    'app/code/community/Vendor/*' => 'app/code/community/Vendor/'
                ]
            ]
        ];
    }

    /**
     * testGetModmanFile
     *
     * @param $modmanData
     *
     * @return void
     *
     * @dataProvider modmanFileDataProvider
     */
    public function testGetModmanFile($modmanData)
    {
        $this->createDummyModmanFile($modmanData);
        $this->assertInstanceOf(
            'Symfony\Component\Finder\SplFileInfo',
            $this->subject->getModmanFile()
        );
    }

    /**
     * testGetModmanFileContent
     *
     * @param $modmanData
     *
     * @return void
     *
     * @dataProvider modmanFileDataProvider
     */
    public function testGetModmanFileContent($modmanData)
    {
        $this->createDummyModmanFile($modmanData);

        for ($i = 0; $i < count($this->subject->getModmanFileLines()); $i++) {
            $line = explode(' ', $this->subject->getModmanFileLines()[$i]);

            $source = trim($line[0]);
            $target = trim($line[1]);

            $expectedSource = trim(array_values(array_flip($modmanData))[$i]);
            $expectedTarget = trim(array_values($modmanData)[$i]);

            $this->assertEquals($expectedSource, $source);
            $this->assertEquals($expectedTarget, $target);
        }
    }
}
