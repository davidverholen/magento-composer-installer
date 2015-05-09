<?php
/**
 * Deploy.php
 *
 * PHP Version 5
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy\Operation
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */

namespace DavidVerholen\Magento\Composer\Installer\Deploy\Operation;

use DavidVerholen\Magento\Composer\Installer\Deploy\Strategy\Factory;
use Composer\DependencyResolver\Operation\OperationInterface;
use Composer\DependencyResolver\PolicyInterface;
use Composer\DependencyResolver\Pool;
use Composer\Package\PackageInterface;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class Deploy
 *
 * @category  DavidVerholen_MagentoComposerInstaller
 * @package   DavidVerholen\Magento\Composer\Installer\Deploy\Operation
 * @author    David Verholen <david@verholen.com>
 * @copyright 2015 David Verholen
 * @license   http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link      http://www.brandung.de
 */
class DeployPackage implements OperationInterface
{
    /**
     * package
     *
     * @var PackageInterface
     */
    protected $package;

    /**
     * deployAction
     *
     * @var string
     */
    protected $deployAction;

    /**
     * sourceDir
     *
     * @var SplFileInfo
     */
    protected $sourceDir;

    /**
     * destDir
     *
     * @var SplFileInfo
     */
    protected $destDir;

    /**
     * @var string
     */
    protected $deployStrategy;

    /**
     * construct deploy Operation
     *
     * @param PackageInterface $package      Package to deploy
     * @param string           $deployAction Deploy Action
     * @param SplFileInfo      $sourceDir    Source Directory
     * @param SplFileInfo      $destDir      Destination Directory
     * @param string           $deployStrategy
     */
    public function __construct(
        PackageInterface $package,
        $deployAction,
        SplFileInfo $sourceDir,
        SplFileInfo $destDir,
        $deployStrategy = Factory::STRATEGY_SYMLINK
    ) {
        $this->package = $package;
        $this->deployAction = $deployAction;
        $this->sourceDir = $sourceDir;
        $this->destDir = $destDir;
        $this->deployStrategy = $deployStrategy;
    }

    /**
     * Returns job type.
     *
     * @return string
     */
    public function getJobType()
    {
        return sprintf(
            "%s-%s",
            $this->getPackage()->getType(),
            $this->getDeployAction()
        );
    }

    /**
     * Returns operation reason.
     *
     * @return string
     */
    public function getReason()
    {
        return sprintf(
            "%s %s Deployment",
            $this->getPackage()->getType(),
            $this->getDeployAction()
        );
    }

    /**
     * Serializes the operation in a human readable format
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "Deployment of %s %s (%s) [%s] <%s>",
            $this->getPackage()->getType(),
            $this->getPackage()->getName(),
            $this->getPackage()->getPrettyVersion(),
            $this->getDeployAction(),
            $this->getDeployStrategy()
        );
    }

    /**
     * getPackage
     *
     * @return PackageInterface
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * DestDir
     *
     * @return SplFileInfo
     */
    public function getDestDir()
    {
        return $this->destDir;
    }

    /**
     * SourceDir
     *
     * @return SplFileInfo
     */
    public function getSourceDir()
    {
        return $this->sourceDir;
    }

    /**
     * getDeployAction
     *
     * @return string
     */
    public function getDeployAction()
    {
        return $this->deployAction;
    }

    /**
     * @return string
     */
    public function getDeployStrategy()
    {
        return $this->deployStrategy;
    }

    /**
     * @param string $deployStrategy
     */
    public function setDeployStrategy($deployStrategy)
    {
        $this->deployStrategy = $deployStrategy;
    }
}
