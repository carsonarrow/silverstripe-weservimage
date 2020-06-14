<?php

namespace CarsonArrow\WeservImage;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\View\ViewableData;

/**
 * Class WeservImage
 * @package carsonarrow\WeservImage
 */
class WeservImage extends ViewableData 
{
    use Configurable;

    /**
     * Default api url
     * @var string
     * @config
     */
    private static $api_url = 'https://images.weserv.nl';

    protected $imageURL;

    protected $options = [];

    public function __construct($imageURL)
    {
        $this->imageURL = $imageURL;
    }

    /**
     * Width
     * Sets the width of the image, in pixels.
     * @link https://images.weserv.nl/docs/size.html#width
     * @param integer $width
     * @return WeservImage $this
     */
    public function Width(int $width)
    {
        return $this->setOption('w', $width);
    }

    /**
     * Height
     * Sets the height of the image, in pixels.
     * @link https://images.weserv.nl/docs/size.html#height
     * @param integer $height
     * @return WeservImage $this
     */
    public function Height(int $height)
    {
        return $this->setOption('h', $height);
    }

    /**
     * Device pixel ratio
     * @link https://images.weserv.nl/docs/size.html#device-pixel-ratio
     * @return WeservImage $this
     */
    public function DPR(int $density)
    {
        return $this->setOption('dpr', $density);
    }

    /**
     * Alignment position
     * How the image should be aligned.
     * @link https://images.weserv.nl/docs/crop.html#alignment-position
     * @param string $alignment
     * @return WeservImage $this
     */
    public function Align(string $alignment)
    {
        return $this->setOption('a', $alignment);
    }

    /**
     * Rectangle crop
     * Crops the image to specific dimensions after any other resize operations.
     * @link https://images.weserv.nl/docs/crop.html#rectangle-crop
     * @param integer $x
     * @param integer $y
     * @param integer $w
     * @param integer $h
     * @param bool $precrop
     * @return WeservImage $this
     */
    public function Crop(int $x, int $y, int $w, int $h, bool $precrop = false)
    {
        $this
            ->setOption('cx', $x)
            ->setOption('cy', $y)
            ->setOption('cw', $w)
            ->setOption('ch', $h);

        if ($precrop) $this->setOption('precrop', $precrop);

        return $this;
    }

    /**
     * Trim
     * Trim "boring" pixels from all edges that contain values within a similarity of the top-left pixel.
     * @link https://images.weserv.nl/docs/crop.html#trim
     * @param integer $tolerance
     * @return WeservImage $this
     */
    public function Trim(int $tolerance = 10)
    {
        return $this->setOption('trim', $tolerance);
    }

    /**
     * Mask
     * Controls the visible and non-visible area of the image.
     * @link https://images.weserv.nl/docs/mask.html
     * @param string $type
     * @param boolean $trim
     * @param string $bg Background color of the mask
     * @return WeservImage $this
     */
    public function Mask(string $type, bool $trim = false, string $bg = '')
    {
        $this->setOption('mask', $type);

        if ($trim) $this->setOption('mtrim', $trim);

        if ($bg) $this->setOption('mbg', $bg);

        return $this;
    }

    /**
     * Flip
     * Flip the image about the vertical Y axis. This always occurs after rotation, if any.
     * @link https://images.weserv.nl/docs/orientation.html#flip
     * @return WeservImage $this
     */
    public function Flip()
    {
        return $this->setOption('flip', true);
    }

    /**
     * Flop
     * Flop the image about the horizontal X axis. This always occurs after rotation, if any.
     * @link https://images.weserv.nl/docs/orientation.html#flop
     * @return WeservImage $this
     */
    public function Flop()
    {
        return $this->setOption('flop', true);
    }

    /**
     * Rotate
     * Rotates the image.
     * @link https://images.weserv.nl/docs/orientation.html#rotation
     * @param integer $degrees
     * @param string $bg Background color when rotating by an angle other than a multiple of 90.
     * @return WeservImage $this
     */
    public function Rotate(int $degrees, string $bg = '')
    {
        $this->setOption('ro', $degrees);

        if ($bg) $this->setOption('rbg', $bg);

        return $this;
    }

    /**
     * Background
     * Sets the background color of the image.
     * @link https://images.weserv.nl/docs/adjustment.html#background
     * @param string $color
     * @return WeservImage $this
     */
    public function Background(string $color)
    {
        return $this->setOption('bg', $color);
    }

    /**
     * Blur
     * Adds a blur effect to the image.
     * @link https://images.weserv.nl/docs/adjustment.html#blur
     * @param integer $blur
     * @return WeservImage $this
     */
    public function Blur(int $blur)
    {
        return $this->setOption('blur', $blur);
    }

    /**
     * Brightness
     * Adjusts the image brightness.
     * @link https://images.weserv.nl/docs/adjustment.html#brightness
     * @param integer $brightness
     * @return WeservImage $this
     */
    public function Brightness(int $brightness)
    {
        return $this->setOption('bri', $brightness);
    }

    /**
     * Contrast
     * Adjusts the image contrast.
     * @link https://images.weserv.nl/docs/adjustment.html#contrast
     * @param integer $contrast
     * @return WeservImage $this
     */
    public function Contrast(int $contrast)
    {
        return $this->setOption('con', $contrast);
    }

    /**
     * Filter
     * Applies a filter effect to the image.
     * @link https://images.weserv.nl/docs/adjustment.html#filter
     * @param string $filter
     * @param string $start
     * @param string $stop
     * @return WeservImage $this
     */
    public function Filter(string $filter, string $start = '', string $stop = '') {
        
        $this->setOption('filt', $filter);

        if ($start) $this->setOption('start', $start);

        if ($stop) $this->setOption('stop', $stop);

        return $this;
    }

    /**
     * Gamma
     * Adjusts the image gamma.
     * @link https://images.weserv.nl/docs/adjustment.html#gamma
     * @param float $gamma
     * @return WeservImage $this
     */
    public function Gamma(float $gamma = 2.2)
    {
        return $this->setOption('gam', $gamma);
    }

    /**
     * Sharpen
     * Sharpen the image.
     * @link https://images.weserv.nl/docs/adjustment.html#sharpen
     * @param float $sharpen
     * @param float $flat
     * @param float $jagged
     * @return WeservImage $this
     */
    public function Sharpen(float $sharpen, float $flat = 0, float $jagged = 0)
    {
        $this->setOption('sharp', $sharpen);

        if ($flat) $this->setOption('sharpf', $flat);

        if ($jagged) $this->setOption('sharpj', $jagged);

        return $this;
    }

    /**
     * Tint
     * Tint the image using the provided chroma while preserving the image luminance.
     * @url https://images.weserv.nl/docs/adjustment.html#tint
     * @param string $tint
     * @return WeservImage $this
     */
    public function Tint(string $tint)
    {
        return $this->setOption('tint', $tint);
    }

    public function getURL()
    {
        $query = http_build_query(array_merge(['url' => $this->imageURL], $this->options));
        $URL = $this->config()->get('api_url') . '?' . $query;

        return $URL;
    }

    public function URL()
    {
        return $this->getURL();
    }

    protected function setOption(string $key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function forTemplate()
    {
        return $this->renderWith(self::class);
    }
}
