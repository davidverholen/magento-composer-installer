<?php
/**
 * FilesystemTestDataProvider.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace Bragento\Test\Magento\Composer\Installer\Util;

use Bragento\Test\Magento\Composer\Installer\AbstractUnitTest;


/**
 * Class FilesystemTestDataProvider
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  Bragento\Magento\Composer\Installer\Util
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class FilesystemDataProvider extends AbstractUnitTest
{
    /**
     * provideSymlinkTestFiles
     *
     * @return array
     */
    public function provideSymlinkTestFiles()
    {
        return array(
            array('test1dir/test1file', 'test1linkdir/test1link'),
            array('test2file', 'test2linkdir/test2link'),
            array('test3dir/test3file', 'test3linkfile')
        );
    }

    /**
     * provideSymlinkTestFiles
     *
     * @return array
     */
    public function provideEmtpyDirTestData()
    {
        return array(
            array('test1dir', array('file1', 'file2', 'file3')),
            array('test2dir', array())
        );
    }

    /**
     * joinFilePathsProvider
     *
     * @return array
     */
    public function joinFilePathsProvider()
    {
        $ds = DIRECTORY_SEPARATOR;
        return array(
            array(
                'app/etc/',
                '/modules',
                'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                'app/etc/',
                'modules',
                'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                'app/etc',
                'modules',
                'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                '/app/etc',
                '/modules',
                $ds . 'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                '/app/etc/',
                '/modules',
                $ds . 'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                '/app/etc',
                'modules/',
                $ds . 'app' . $ds . 'etc' . $ds . 'modules' . $ds
            ),
            array(
                'app\\etc\\',
                '\\modules',
                'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                'app\\etc\\',
                'modules',
                'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                'app\\etc',
                'modules',
                'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                '\\app\\etc',
                '\\modules',
                $ds . 'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                '\\app\\etc\\',
                '\\modules',
                $ds . 'app' . $ds . 'etc' . $ds . 'modules'
            ),
            array(
                '\\app\\etc',
                'modules\\',
                $ds . 'app' . $ds . 'etc' . $ds . 'modules' . $ds
            )
        );
    }


}
