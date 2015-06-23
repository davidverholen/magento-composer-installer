<?php
/**
 * Base.php
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

use Composer\Composer;
use Composer\Config;
use Composer\IO\ConsoleIO;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use DavidVerholen\Magento\Composer\Installer\App\SerializerFactory;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class Base
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  ${NAMESPACE}
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var IOInterface
     */
    private $io;

    /**
     * @var vfsStreamDirectory
     */
    private $root;

    protected function setUp()
    {
        $this->root = vfsStream::setup('root');
        SerializerFactory::setMetadataDir($this->getMetadataDir());

        parent::setUp();
    }

    /**
     * getRoot
     *
     * @return vfsStreamDirectory
     */
    protected function getRoot()
    {
        return $this->root;
    }

    /**
     * getComposer
     *
     * @return Composer
     */
    protected function getComposer()
    {
        if (null === $this->composer) {
            $this->composer = new Composer();
        }

        return $this->composer;
    }

    /**
     * getIo
     *
     * @return ConsoleIO|IOInterface
     */
    protected function getIo()
    {
        if (null === $this->io) {
            $this->io = new ConsoleIO(
                new ArgvInput(),
                new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG),
                new HelperSet()
            );
        }

        return $this->io;
    }

    /**
     * getTestConfig
     *
     * @return Config
     */
    protected function getTestConfig()
    {
        $config = new Config();

        return $config;
    }

    /**
     * getTestServiceConfigDir
     *
     * @return string
     */
    protected function getTestServiceConfigDir()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                APPLICATION_BASE_DIR,
                Plugin::APP_RES_DIR,
                Plugin::APP_CONFIG_DIR
            ]
        );
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

    /**
     * getDummyPackage
     *
     * @return Package
     */
    protected function getDummyPackage()
    {
        $package = new Package('test', '1.0.0', '1.0.0');
        $package->setTargetDir(vfsStream::url('root'));

        return $package;
    }

    /**
     * getTestFileContent
     *
     * @param $path
     *
     * @return string
     */
    protected function getTestFileContent(array $path)
    {
        return file_get_contents(implode(
            DIRECTORY_SEPARATOR,
            array_merge(
                [
                    APPLICATION_BASE_DIR,
                    Plugin::APP_RES_DIR,
                    'tests'
                ],
                $path
            )
        ));
    }
}
