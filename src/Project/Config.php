<?php
/**
 * Config.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Project
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Project;

use DavidVerholen\Magento\Composer\Installer\Deploy\Strategy\Factory;
use DavidVerholen\Magento\Composer\Installer\Project\Exception\ConfigKeyNotDefinedException;
use DavidVerholen\Magento\Composer\Installer\Util\Filesystem;
use Composer\Composer;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class Config
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Project
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class Config
{
    const MAGENTO_ROOT_DIR_KEY = 'magento-root-dir';
    const DEFAULT_MAGENTO_ROOT_DIR = 'magento';

    const MAGENTO_FORCE_KEY = 'magento-force';
    const OVERRIDE_FORCE = 'override';

    const PERSISTENT_FILES_KEY = 'persistent-files';

    const DEPLOY_STRATEGY_KEY = 'magento-deploystrategy';
    const DEPLOY_STRATEGY_OVERWRITE_KEY = 'magento-deploystrategy-overwrite';

    const AUTOAPPEND_GITIGNORE_KEY = 'auto-append-gitignore';

    /**
     * _instance
     *
     * @var Config
     */
    protected static $instance;

    /**
     * _composer
     *
     * @var Composer
     */
    protected static $composer;

    /**
     * _magentoRootDir
     *
     * @var SplFileInfo
     */
    protected $magentoRootDir;

    /**
     * _fs
     *
     * @var Filesystem
     */
    protected $fs;

    /**
     * extra
     *
     * @var array
     */
    protected $extra;

    /**
     * private constructor for singleton
     */
    private function __construct()
    {
        $this->fs = new Filesystem();
        $this->extra = self::$composer->getPackage()->getExtra();
    }

    /**
     * getMagentoRootDir
     *
     * @return SplFileInfo
     */
    public function getMagentoRootDir()
    {
        if (null === $this->magentoRootDir) {
            $dir
                = $this->getExtraValue(self::MAGENTO_ROOT_DIR_KEY) === null
                ? self::DEFAULT_MAGENTO_ROOT_DIR
                : $this->getExtraValue(self::MAGENTO_ROOT_DIR_KEY);

            $this->fs->ensureDirectoryExists($dir);
            $this->magentoRootDir = new SplFileInfo($dir, $dir, $dir);
        }
        return $this->magentoRootDir;
    }

    /**
     * getMagentoOverride
     *
     * @return string
     */
    public function getMagentoOverride()
    {
        return $this->getExtraValue(self::MAGENTO_FORCE_KEY);
    }

    /**
     * getDeployStrategy
     *
     * @return string
     */
    public function getDeployStrategy()
    {
        $strategy = $this->getExtraValue(self::DEPLOY_STRATEGY_KEY);
        return null === $strategy ? Factory::STRATEGY_SYMLINK : $strategy;
    }

    /**
     * getAutoappendGitignore
     *
     * @return boolean
     */
    public function getAutoappendGitignore()
    {
        return null !== $this->getExtraValue(self::AUTOAPPEND_GITIGNORE_KEY)
            && false !== $this->getExtraValue(self::AUTOAPPEND_GITIGNORE_KEY);
    }

    /**
     * getDeployStrategyOverwrite
     *
     * @return array
     */
    public function getDeployStrategyOverwrite()
    {
        $strategies = $this->getExtraValue(self::DEPLOY_STRATEGY_OVERWRITE_KEY);
        return is_array($strategies) ? $strategies : array();
    }

    /**
     * getPersistentFiles
     *
     * @return array
     */
    public function getPersistentFiles()
    {
        $files = $this->getExtraValue(self::PERSISTENT_FILES_KEY);
        return $files !== null ? $files : array();
    }

    /**
     * isForcedOverride
     *
     * @return bool
     */
    public function isForcedOverride()
    {
        return self::OVERRIDE_FORCE === $this->getMagentoOverride();
    }

    /**
     * getVendorDir
     *
     * @return mixed
     */
    public function getVendorDir()
    {
        return self::$composer->getConfig()->get('vendor-dir', 1);
    }

    /**
     * init
     *
     * @param Composer $composer
     *
     * @return void
     */
    public static function init(Composer $composer)
    {
        self::$composer = $composer;
    }

    /**
     * getInstance
     *
     * @return Config
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    /**
     * getValueFromArray
     *
     * @param string $key
     * @param array  $array
     * @param bool   $required
     *
     * @return mixed
     * @throws Exception\ConfigKeyNotDefinedException
     */
    protected function getValueFromArray($key, array $array, $required = false)
    {
        if (!isset($array[$key])) {
            if ($required) {
                throw new ConfigKeyNotDefinedException($key);
            } else {
                return null;
            }
        }

        return $array[$key];
    }

    /**
     * getExtraConfig
     *
     * @param string $key
     * @param bool   $required
     *
     * @return mixed
     */
    protected function getExtraValue($key, $required = false)
    {
        return $this->getValueFromArray($key, $this->extra, $required);
    }
}
