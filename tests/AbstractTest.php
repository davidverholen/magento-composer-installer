<?php
/**
 * AbstractTest.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   ${NAMESPACE}
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace Bragento\Test\Magento\Composer\Installer;

use DavidVerholen\Magento\Composer\Installer\Util\Filesystem;
use org\bovigo\vfs\vfsStream;

/**
 * Class AbstractTest
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   ${NAMESPACE}
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    const VFS_ROOT = 'root';

    const TEST_ROOT_DIR = 'root';

    const BUILD_ROOT = 'build';

    const TEST_FILES_DIR = 'files';

    /**
     * _fs
     *
     * @var Filesystem
     */
    private $filesystem;

    protected function setUp()
    {
        parent::setUp();
        $this->getFilesystem()->emptyDirectory($this->getBuildDir());
        vfsStream::setup(self::VFS_ROOT);
    }

    protected function toBuildDir()
    {
        chdir($this->getBuildDir());
    }

    /**
     * getBuildDir
     *
     * @return \Symfony\Component\Finder\SplFileInfo
     */
    protected function getBuildDir()
    {
        return $this->getFilesystem()
            ->getDir(TEST_BUILD_DIR);

    }

    /**
     * getFs
     *
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        if (null === $this->filesystem) {
            $this->filesystem = new Filesystem();
        }

        return $this->filesystem;
    }

    /**
     * getVfsDir
     *
     * @param $url
     *
     * @return string
     */
    protected function getTestResDir($url)
    {
        return TEST_RES_BASE_DIR .
        DIRECTORY_SEPARATOR .
        $url;
    }

    /**
     * createTestFiles
     *
     * @param array $files
     *
     * @return void
     */
    protected function createTestFiles(array $files)
    {
        foreach ($files as $file) {
            $this->createTestFile($file);
        }
    }

    /**
     * @param $path
     */
    protected function createTestFile($path)
    {
        if (count($this->getFilesystem()->getPathParts($path)) > 1) {
            $this->getFilesystem()->mkdir(dirname($path), 0755, true);
        }

        touch($path);
    }

    /**
     * getAbsPath
     *
     * @param $path
     *
     * @return string
     */
    protected function getAbsPath($path)
    {
        return realpath($path);
    }

    protected function tearDown()
    {
        chdir($this->getOriginalCwd());
        $this->getFilesystem()->emptyDirectory($this->getBuildDir());
        parent::tearDown();
    }

    protected function getOriginalCwd()
    {
        return dirname(realpath(__FILE__));
    }


}
