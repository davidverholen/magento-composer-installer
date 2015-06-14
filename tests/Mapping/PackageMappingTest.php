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

use DavidVerholen\Magento\Composer\Installer\App\SerializerFactory;
use DavidVerholen\Magento\Composer\Installer\AbstractTest;
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

    protected function setUp()
    {
        parent::setUp();
        SerializerFactory::setMetadataDir($this->getMetadataDir());

        $this->subject = new PackageMapping(
            new Filesystem(),
            new Finder(),
            SerializerFactory::createSerializer()
        );

        $this->subject->setPackage($this->getDummyPackage());
    }

    /**
     * getMetadataDir
     *
     * @return string
     */
    protected function getMetadataDir()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $this->getTestServiceConfigDir(),
                Plugin::APP_SERIALIZER_CONFIG_DIR
            ]
        );
    }

    public function testSerialize()
    {
        $packageEntity = new Package();
        $packageEntity->setName('testName');
        $packageEntity->setChannel('community');
        $packageEntity->setDescription('description');
        $packageEntity->setLicense('OSL-3.0');
        $packageEntity->setStability('stable');
        $packageEntity->setSummary('Summary');

        $xml = $this->subject->getSerializer()->serialize($packageEntity, 'xml');

        $newPackageEntity = $this->subject->getSerializer()->deserialize(
            $xml,
            get_class($packageEntity),
            'xml'
        );

        $this->assertEquals($packageEntity, $newPackageEntity);
    }
}
