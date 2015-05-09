<?php
/**
 * DeployEvent.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy\Event;

use DavidVerholen\Magento\Composer\Installer\Deploy\Operation\DeployPackage;
use Composer\Composer;
use Composer\DependencyResolver\Operation\OperationInterface;
use Composer\EventDispatcher\Event;
use Composer\IO\IOInterface;

/**
 * Class DeployEvent
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  Bragento\Magento\Composer\Installer\Deploy\Event
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DeployEvent extends Event
{

    /**
     * @var DeployPackage
     */
    protected $operation;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @param string                           $name
     * @param Composer                         $composer
     * @param IOInterface                      $io
     * @param DeployPackage $operation
     */
    public function __construct(
        $name,
        Composer $composer,
        IOInterface $io,
        DeployPackage $operation
    ) {
        parent::__construct($name);

        $this->operation = $operation;
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * @return DeployPackage
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param OperationInterface $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return Composer
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * @param Composer $composer
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;
    }

    /**
     * @return IOInterface
     */
    public function getIo()
    {
        return $this->io;
    }

    /**
     * @param IOInterface $io
     */
    public function setIo($io)
    {
        $this->io = $io;
    }
}
