<?php
/**
 * Factory.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy\Strategy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy\Strategy;

use DavidVerholen\Magento\Composer\Installer\Deploy\Manager\PackageTypes;
use DavidVerholen\Magento\Composer\Installer\Project\Config;
use DavidVerholen\Magento\Composer\Installer\Util\Filesystem;
use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class Factory
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy\Strategy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class Factory
{
    const STRATEGY_COPY = 'Copy';
    const STRATEGY_SYMLINK = 'Symlink';
    const STRATEGY_NONE = 'None';

    const NS = '\\Bragento\\Magento\\Composer\\Installer\\Deploy\\Strategy\\';

    /**
     * @var array
     */
    protected static $allowedStrategies
        = array(
            self::STRATEGY_SYMLINK,
            self::STRATEGY_COPY,
            self::STRATEGY_NONE
        );

    /**
     * deployStrategies
     *
     * @var array
     */
    protected static $deployStrategies;

    /**
     * @var array
     */
    protected static $overwrites;

    /**
     * _composer
     *
     * @var Composer
     */
    protected static $composer;

    /**
     * Composer IO Interface
     *
     * @var IOInterface
     */
    protected static $io;

    /**
     * init
     *
     * @param Composer    $composer composer instance
     * @param IOInterface $io       IO INterface
     *
     * @return void
     */
    public static function init(Composer $composer, IOInterface $io)
    {
        self::$composer = $composer;
        self::$io = $io;
        self::$deployStrategies = array();
    }

    /**
     * getStrategy
     *
     * @param PackageInterface $package   Package to Deploy
     * @param string           $action    Deploy Action
     * @param SplFileInfo      $sourceDir Source Dir
     * @param SplFileInfo      $destDir   Target Dir
     *
     * @return AbstractStrategy
     */
    public static function get(
        PackageInterface $package,
        $action,
        SplFileInfo $sourceDir,
        SplFileInfo $destDir
    ) {
        if (!isset(self::$deployStrategies[$package->getName()])) {
            switch ($package->getType()) {
                case PackageTypes::MAGENTO_CORE:
                    $strategy = self::STRATEGY_COPY;
                    break;

                case PackageTypes::MAGENTO_MODULE:
                case PackageTypes::MAGENTO_THEME:
                    $strategy = self::getPackageDeployStrategy($package);
                    break;

                default:
                    $strategy = self::STRATEGY_NONE;
            }

            $classname = self::getClassName($strategy);

            self::$deployStrategies[$package->getName()] = new $classname(
                $package,
                $sourceDir,
                $destDir,
                $action,
                self::$composer,
                self::$io
            );
        }

        return self::$deployStrategies[$package->getName()];
    }

    /**
     * getPackageDeployStrategy
     *
     * @param PackageInterface $package
     *
     * @return string
     */
    protected static function getPackageDeployStrategy(
        PackageInterface $package
    ) {
        $nameParts = Filesystem::getInstance()
            ->getPathParts($package->getName());

        if (count($nameParts) !== 2) {
            return self::getDefaultStrategy();
        }

        $strategy = self::normalizeStrategy(
            self::getOverwrite($nameParts[0], $nameParts[1])
        );

        return in_array($strategy, self::$allowedStrategies)
            ? $strategy
            : self::getDefaultStrategy();
    }

    /**
     * getOverwrites
     *
     * @return array
     */
    protected static function getOverwrites()
    {
        if (null === self::$overwrites) {
            $overwriteConfig = Config::getInstance()
                ->getDeployStrategyOverwrite();

            self::$overwrites = array();
            foreach ($overwriteConfig as $key => $value) {
                $nameParts = Filesystem::getInstance()->getPathParts($key);
                if (count($nameParts) === 2) {
                    $vendor = $nameParts[0];
                    $name = $nameParts[1];
                    if (!isset(self::$overwrites[$vendor])) {
                        self::$overwrites[$vendor] = array();
                    }
                    self::$overwrites[$vendor][$name] = $value;
                }
            }
        }

        return self::$overwrites;
    }

    /**
     * getOverwrite
     *
     * @param $vendor
     * @param $name
     *
     * @return string
     */
    protected static function getOverwrite($vendor, $name)
    {
        $overwrites = self::getOverwrites();
        if (!isset($overwrites[$vendor])
            || !isset($overwrites[$vendor][$name])
        ) {
            return self::getDefaultStrategy();
        }

        return $overwrites[$vendor][$name];
    }

    /**
     * normalizeStrategy
     *
     * @param $strategy
     *
     * @return string
     */
    protected static function normalizeStrategy($strategy)
    {
        return ucfirst(strtolower($strategy));
    }

    /**
     * getDefaultStrategy
     *
     * @return string
     */
    protected static function getDefaultStrategy()
    {
        $strategy = self::normalizeStrategy(
            Config::getInstance()->getDeployStrategy()
        );

        return in_array($strategy, self::$allowedStrategies)
            ? $strategy
            : self::STRATEGY_SYMLINK;
    }

    /**
     * get strategy classname by strategy name
     *
     * @param string $strategy
     *
     * @return string
     */
    protected static function getClassName($strategy)
    {
        return self::NS . $strategy;
    }
}
