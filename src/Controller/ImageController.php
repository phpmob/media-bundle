<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\MediaBundle\Controller;

use PhpMob\MediaBundle\Model\ImageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PhpMob\MediaBundle\Imagine\Cache\CacheManager;

class ImageController extends Controller
{
    /**
     * @return CacheManager
     */
    private function getImagineCacheManager()
    {
        return $this->container->get('liip_imagine.cache.manager');
    }

    /**
     * @param string $path
     * @param string $sizing
     * @param string $mode
     * @param string $filter
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function filterRuntimeAction($path, $sizing, $mode = 'inset', $filter = 'strip')
    {
        if ($path instanceof ImageInterface) {
            $path = $path->getPath();
        }

        $runtimeConfig = [
            'thumbnail' => [
                'size' => explode('x', strtolower($sizing)),
                'mode' => $mode,
            ],
        ];

        return $this->redirect(
            $this->getImagineCacheManager()->getBrowserPath($path, $filter, $runtimeConfig
        ));
    }
}
