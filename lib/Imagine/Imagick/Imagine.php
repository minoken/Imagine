<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imagine\Imagick;

use Imagine\Color;
use Imagine\Exception\InvalidArgumentException;
use Imagine\ImagineInterface;

class Imagine implements ImagineInterface
{
    /**
     * (non-PHPdoc)
     * @see Imagine.ImagineInterface::open()
     */
    public function open($path)
    {
        if (!is_file($path)) {
            throw new InvalidArgumentException(sprintf('File %s doesn\'t '.
                'exist', $path));
        }

        return new Image(new \Imagick($path), $this);
    }

    /**
     * (non-PHPdoc)
     * @see Imagine.ImagineInterface::create()
     */
    public function create($width, $height, Color $color = null)
    {
        if ($width < 1 || $height < 1) {
            throw new InvalidArgumentException('Width an height of the '.
                'resize must be positive integers');
        }

        $color = null !== $color ? $color : new Color('fff');

        $imagick = new \Imagick();
        $imagick->newImage($width, $height, new \ImagickPixel(
            sprintf('rgba(%d,%d,%d,%d)',
            $color->getRed(), $color->getGreen(), $color->getBlue(),
            abs(1 - round($color->getAlpha() / 100, 1))
        )));

        return new Image($imagick, $this);
    }
}