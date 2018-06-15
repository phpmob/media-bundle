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

use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DownloadController
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $path
     *
     * @return Response
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function downloadAction(string $path): Response
    {
        if (!$meta = $this->filesystem->getMetadata($path)) {
            throw new NotFoundHttpException('Media not found: ' . $path);
        }

        $content = $this->filesystem->read($path);

        $response = new Response($content);
        $response->headers->set('Content-Type', $meta['mimetype']);
        $response->headers->set('Content-Length', $meta['size']);
        $response->headers->set('Content-Transfer-Encoding', 'binary');

        $name = explode('/', $path);

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $name[count($name) - 1]);
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
