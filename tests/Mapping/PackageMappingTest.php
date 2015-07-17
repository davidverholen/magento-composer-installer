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
use DavidVerholen\Magento\Composer\Installer\Mapping\Parser\PackageParser;
use org\bovigo\vfs\vfsStream;
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
    const PACKAGE_ENTITY_CLASS = 'DavidVerholen\Magento\Composer\Installer\Entity\Serializable\Package';

    const SERIALIZE_FORMAT = 'xml';

    const PACKAGE_FILENAME = 'package.xml';

    /** @var PackageParser */
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

        $this->subject = new PackageParser(
            new Filesystem(),
            new Finder(),
            SerializerFactory::createSerializer()
        );

        $this->subject->setPackageTargets($this->targets);
        $this->subject->setPackage($this->getDummyPackage());
        $this->subject->setPackageEntityClass(self::PACKAGE_ENTITY_CLASS);
        $this->subject->setSerializeFormat(self::SERIALIZE_FORMAT);
        $this->subject->setPackageFileName(self::PACKAGE_FILENAME);
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
            ['dibsfw.xml', 'Dibsfw']
        ];
    }

    /**
     * testParsePackageXmlFile
     *
     * @param $fileName
     * @param $packageName
     *
     * @dataProvider packageXmlFileNameDataProvider
     */
    public function testParsePackageXmlFile($fileName, $packageName)
    {
        $this->createDummyPackageFile($fileName);
        $this->assertEquals(
            $packageName,
            $this->subject->getPackageEntity()->getName()
        );
    }

    /**
     * testSupports
     *
     * @param $fileName
     * @param $packageName
     *
     * @return void
     *
     * @dataProvider packageXmlFileNameDataProvider
     */
    public function testSupports($fileName, $packageName)
    {
        $this->createDummyPackageFile($fileName);
        $this->assertTrue($this->subject->isSupported($this->getDummyPackage()));
    }

    /**
     * testSupportsNot
     *
     * @param $fileName
     * @param $packageName
     *
     * @return void
     *
     * @dataProvider packageXmlFileNameDataProvider
     */
    public function testSupportsNot($fileName, $packageName)
    {
        $this->assertFalse($this->subject->isSupported($this->getDummyPackage()));
    }

    /**
     * getPackageFilePath
     *
     * @return string
     */
    protected function getPackageFilePath()
    {
        return vfsStream::url('root/package.xml');
    }

    /**
     * createDummyPackageFile
     *
     * @param $testFileName
     */
    protected function createDummyPackageFile($testFileName)
    {
        file_put_contents(
            $this->getPackageFilePath(),
            $this->getTestFileContent(['mapping', 'package', $testFileName])
        );
    }
}
