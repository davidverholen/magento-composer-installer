<?php
/**
 * Composer.php
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

/**
 * Class Composer
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Mapping
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 *
 * @todo      add fullstacktest for composer mapping
 */
class Composer extends AbstractMapping
{
    const COMPOSER_MAP_KEY = 'map';

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
     * @return array
     */
    protected function parseMappings()
    {
        $extra = $this->getPackage()->getExtra();

        if (!isset($extra[self::COMPOSER_MAP_KEY])
            || !is_array($extra[self::COMPOSER_MAP_KEY])
        ) {
            return array();
        }

        return $this->translateComposerMapping($extra[self::COMPOSER_MAP_KEY]);
    }

    /**
     * translateComposerMapping
     *
     * @param array $composerMap
     *
     * @return array
     */
    protected function translateComposerMapping(array $composerMap)
    {
        $map = array();
        foreach ($composerMap as $mapEntry) {
            $map[$mapEntry[0]] = $mapEntry[1];
        }
        return $map;
    }
}
