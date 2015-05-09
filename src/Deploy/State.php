<?php
/**
 * State.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy;

use DavidVerholen\Magento\Composer\Installer\Deploy\Strategy\AbstractStrategy;
use DavidVerholen\Magento\Composer\Installer\Util\Filesystem;
use Composer\Package\PackageInterface;

/**
 * Class State
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class State
{
    const MAPPINGS_KEY = 'mappings';

    /**
     * target dir for state files
     */
    const STATE_DIR = '.mage-deploy';

    /**
     * _fs
     *
     * @var Filesystem
     */
    protected $fs;

    /**
     * _state
     *
     * @var array
     */
    protected $state;

    /**
     * package
     *
     * @var PackageInterface
     */
    protected $package;

    /**
     * _deployStrategy
     *
     * @var AbstractStrategy
     */
    protected $deployStrategy;

    /**
     * _saveOnDestruct
     *
     * @var Boolean
     */
    protected $saveOnDestruct;

    /**
     * load on construct
     *
     * @param AbstractStrategy $strategy
     */
    public function __construct(AbstractStrategy $strategy)
    {
        $this->saveOnDestruct = true;
        $this->deployStrategy = $strategy;
        $this->state = $this->load($this->getPackage());
    }

    /**
     * save on destruct
     */
    public function __destruct()
    {
        if ($this->saveOnDestruct) {
            $this->persist($this->state);
        }
    }

    /**
     * setMapping
     *
     * @param array $map
     *
     * @return void
     */
    public function setMapping(array $map)
    {
        $this->set(self::MAPPINGS_KEY, $map);
    }

    /**
     * getMapping
     *
     * @return array
     */
    public function getMapping()
    {
        return (array)$this->get(self::MAPPINGS_KEY);
    }

    /**
     * set
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    protected function set($key, $value)
    {
        $this->state[$key] = $value;
    }

    /**
     * get
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function get($key)
    {
        return isset($this->state[$key])
            ? $this->state[$key]
            : null;
    }

    /**
     * save
     *
     * @param array $state
     *
     * @return void
     */
    protected function persist(array $state)
    {
        $this->getFs()->ensureDirectoryExists(
            dirname($this->getStateFilePath())
        );
        file_put_contents(
            $this->getStateFilePath(),
            json_encode($state)
        );
    }

    /**
     * save
     *
     * public function for manual save, since hhvm does not
     * support automated invocation of __destruct on
     * shutdown
     *
     * @return void
     *
     * @todo check if hhvm now supports automated __destruct
     */
    public function save()
    {
        $this->persist($this->state);
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        if (file_exists($this->getStateFilePath())) {
            unlink($this->getStateFilePath());
        }
        $this->saveOnDestruct = false;
    }

    /**
     * load
     *
     * @param PackageInterface $package
     *
     * @return array
     */
    public static function load(PackageInterface $package)
    {
        $stateFilePath = Manager::getInstance()->getStateFilePath($package);
        if (file_exists($stateFilePath)) {
            return (array)json_decode(
                file_get_contents(
                    $stateFilePath
                )
            );
        }

        return array();
    }

    /**
     * getFs
     *
     * @return Filesystem
     */
    protected function getFs()
    {
        if (null === $this->fs) {
            $this->fs = new Filesystem();
        }

        return $this->fs;
    }

    /**
     * getMappingsFilePath
     *
     * @return string
     */
    protected function getStateFilePath()
    {
        return Manager::getInstance()->getStateFilePath($this->getPackage());
    }

    /**
     * getPackage
     *
     * @return PackageInterface
     */
    protected function getPackage()
    {
        if (null === $this->package) {
            $this->package = $this->getDeployStrategy()->getPackage();
        }
        return $this->package;
    }

    /**
     * getDeployStrategy
     *
     * @return AbstractStrategy
     */
    protected function getDeployStrategy()
    {
        return $this->deployStrategy;
    }
}
