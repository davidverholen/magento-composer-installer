<?php
/**
 * Modman.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Mapping
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Mapping;

use DavidVerholen\Magento\Composer\Installer\Mapping\Exception\MappingParseException;

/**
 * Class Modman
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Mapping
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class Modman extends AbstractMapping
{
    const MODMAN_FILE_NAME = 'modman';

    const EXPECTED_PARTS_COUNT = '2';

    protected $ignoreStartsWith
        = array(
            '#',
            '@'
        );

    /**
     * _pathMappingTranslations
     *
     * get the mappings from the source and return them
     *
     * * $example = array(
     * *    $source1 => $target1,
     * *    $source2 => target2
     * * )
     *
     * @throws MappingParseException
     * @return array
     */
    protected function parseMappings()
    {
        $map = array();
        $file = $this->getModmanFileObject();

        while (!$file->eof()) {
            $line = trim($file->getCurrentLine());

            if ($line === '' || in_array($line[0], $this->ignoreStartsWith)) {
                continue;
            }

            $parts = preg_split(
                '/\s+/',
                $line,
                self::EXPECTED_PARTS_COUNT,
                PREG_SPLIT_NO_EMPTY
            );

            if (count($parts) != 2) {
                throw new MappingParseException(
                    sprintf(
                        'Invalid row on line %d has %d parts, expected %d',
                        $file->current(),
                        count($parts),
                        self::EXPECTED_PARTS_COUNT
                    )
                );
            }
            $map[$parts[0]] = $parts[1];
            $file->next();
        }

        return $map;
    }

    /**
     * getModmanFileObject
     *
     * @return \SplFileObject
     */
    protected function getModmanFileObject()
    {
        return new \SplFileObject(
            $this->getFs()->getFile(
                $this->getModuleDir()->getPathname(),
                self::MODMAN_FILE_NAME
            )->getPathname()
        );
    }
}
