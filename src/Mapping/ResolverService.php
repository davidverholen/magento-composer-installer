<?php
 /**
 * MappingResolver.php
 *
 * PHP Version 5
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  DavidVerholen_MagentoComposerInstaller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Magento\Composer\Installer\Mapping;

use DavidVerholen\Magento\Composer\Installer\App\AbstractService;
use DavidVerholen\Magento\Composer\Installer\Mapping\Parser\ParserInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class MappingResolver
 *
 * @category DavidVerholen_MagentoComposerInstaller
 * @package  Mapping
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ResolverService extends AbstractService
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * resolve
     *
     * @param ParserInterface $parser
     *
     * @return MapCollection
     */
    public function resolve(ParserInterface $parser)
    {
        /** @todo resolve mappings to file paths */
        return $parser->getMappings();
    }
}
