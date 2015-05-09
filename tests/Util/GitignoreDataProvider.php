<?php
 /**
 * GitignoreDataProvider.php
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
 * Class GitignoreDataProvider
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  Bragento\Test\Magento\Composer\Installer\Util
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class GitignoreDataProvider extends AbstractUnitTest
{
    /**
     * provideGitignoreEntries
     *
     * @return array array(array $entries)
     */
    public function provideGitignoreEntries()
    {
        return array(
            array(
                array(
                    'file1',
                    'file2',
                    'dir1/file1',
                    'dir1/file2',
                    'dir2/',
                    'dir3/file1',
                    'dir3/dir4/file1',
                    'dir3/dir4/file2',
                    'dir3/file2'
                )
            )
        );
    }

    /**
     * provideDuplicateEntries
     *
     * @return array array(array $entries, array $expected)
     */
    public function provideDuplicateEntries()
    {
        return array(
            array(
                array(
                    'file1',
                    'file2',
                    'dir1/file1',
                    'file1',
                    'file2',
                    'dir1/file1',
                    'dir2',
                    'dir2/file1',
                    'dir2/file2'
                ),
                array(
                    'file1',
                    'file2',
                    'dir1/file1',
                    'dir2'
                )
            )
        );
    }

    /**
     * provideRemoveEntriesData
     *
     * @return array array($entries, $toRemove)
     */
    public function provideRemoveEntriesData()
    {
        return array(
            array(
                array(
                    'file1',
                    'file2',
                    'dir1/file1'
                ),
                array(
                    'file1',
                    'file2'
                )
            )
        );
    }
}
