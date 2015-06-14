<?php
/**
 * PackageMappingTest.php
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
use DavidVerholen\Magento\Composer\Installer\App\SerializerFactory;
use DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package;
use DavidVerholen\Magento\Composer\Installer\Plugin;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class PackageMappingTest
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen\Magento\Composer\Installer\Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class PackageMappingTest extends AbstractTest
{
    /** @var PackageMapping */
    protected $subject;

    /**
     * _targets
     *
     * @var array
     */
    protected $targets
        = array(
            'magelocal'     => './app/code/local',
            'magecommunity' => './app/code/community',
            'magecore'      => './app/code/core',
            'magedesign'    => './app/design',
            'mageetc'       => './app/etc',
            'magelib'       => './lib',
            'magelocale'    => './app/locale',
            'magemedia'     => './media',
            'mageskin'      => './skin',
            'mageweb'       => '.',
            'magetest'      => './tests',
            'mage'          => '.'
        );

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new PackageMapping(
            new Filesystem(),
            new Finder(),
            SerializerFactory::createSerializer()
        );

        $this->subject->setPackageTargets($this->targets);
        $this->subject->setPackage($this->getDummyPackage());
    }

    public function testSerialize()
    {
        $author = new Package\Author();
        $author->setName('test author');
        $author->setUser('testauthor');
        $author->setEmail('test@author.de');

        $packageEntity = new Package();
        $packageEntity->setName('testName');
        $packageEntity->setChannel('community');
        $packageEntity->setDescription('description');
        $packageEntity->setLicense('OSL-3.0');
        $packageEntity->setStability('stable');
        $packageEntity->setSummary('Summary');
        $packageEntity->setNotes('notes');
        $packageEntity->setAuthors([$author]);
        $packageEntity->setContents([]);

        $xml = $this->subject->getSerializer()
            ->serialize($packageEntity, 'xml');

        $newPackageEntity = $this->subject->getSerializer()->deserialize(
            $xml,
            get_class($packageEntity),
            'xml'
        );

        $this->assertEquals($packageEntity, $newPackageEntity);
    }

    /**
     * packageXmlFileNameDataProvider
     *
     * @return array
     */
    public function packageXmlFileNameDataProvider()
    {
        return [
            ['dibsfw.xml']
        ];
    }

    /**
     * testParsePackageXmlFile
     *
     * @param $fileName
     *
     * @return void
     *
     * @dataProvider packageXmlFileNameDataProvider
     */
    public function testParsePackageXmlFile($fileName)
    {
        $xml = $this->getTestFileContent($fileName);

        /** @var Package $packageEntity */
        $packageEntity = $this->subject->getSerializer()->deserialize(
            $xml,
            'DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package',
            'xml'
        );

        $this->assertEquals('Dibsfw', $packageEntity->getName());
    }

    /**
     * getTestFile
     *
     * @param $name
     *
     * @return string
     */
    protected function getTestFileContent($name)
    {
        return file_get_contents(implode(
            DIRECTORY_SEPARATOR,
            [
                APPLICATION_BASE_DIR,
                Plugin::APP_RES_DIR,
                'tests',
                'mapping',
                'package',
                $name
            ]
        ));
    }
}
