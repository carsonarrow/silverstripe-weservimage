<?php
namespace CarsonArrow\WeservImage;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\View\ViewableData;
use SilverStripe\Control\HTTP;

/**
 * Class WeservImage
 * @package carsonarrow\WeservImage
 */
class WeservImage extends ViewableData 
{
    use Configurable;

    /**
     * Default api url
     * 
     * @config
     *
     * @var string
     */
    private static $api_url = 'https://images.weserv.nl';

    private static $default_image;

    protected $URL;

    public function __construct($imageURL)
    {
        $apiUrl = static::config()->get('api_url');
        $URL = $apiUrl . '?url=' . urlencode(preg_replace('(^https?://)', '', $imageURL));
        $this->URL = $URL;
    }

    /**
     * @param string $URL
     * @return void
     */
    public function setURL($URL)
    {
        $this->URL = $URL;
    }
    
    /**
     * @return string
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * @return string
     */
    public function URL()
    {
        return $this->getURL();
    }

    /**
     * Updates URL
     *
     * @param [type] $params
     * @return void
     */
    public function updateURL($params)
    {

        if (is_array($params)) {
        
            foreach ($params as $param => $value)
            {
                $this->URL = HTTP::setGetVar($param, $value, $this->URL);
            }
        } else {
            $this->URL = HTTP::setGetVar($params, null, $this->URL);
        }
    }

    /**
     * Image width
     *
     * @param integer $w
     * @return void
     */
    public function Width(int $w)
    {
        $this->updateURL(['w' => $w]);

        return $this;
    }

    /**
     * Image height
     *
     * @param integer $h
     * @return void
     */
    public function Height(int $h)
    {
        $this->updateURL(['h' => $h]);

        return $this;
    }

    /**
     * Image device pixel ratio (DPR)
     *
     * @param integer $dpr 1-8
     * @return void
     */
    public function DPR(int $dpr)
    {
        if ($dpr >= 1 && $dpr <= 8)
        {
            $this->updateURL(['dpr' => $dpr]);
        }

        return $this;
    }

    /**
     * Image transformation
     * https://images.weserv.nl/#trans
     * 
     * @param string $type
     * @return $this
     */
    public function Transformation(string $t)
    {
        $this->updateURL(['t' => $t]);

        return $this;
    }

    /**
     * Image crop
     * 
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     * @return $this
     */
    public function Crop(int $width, int $height, int $x = 0, int $y = 0)
    {
        $this->updateURL(['crop' => implode(',', [$width, $height, $x, $y])]);

        return $this;
    }

    /**
     * Image crop alignment
     *
     * @param string $a
     * @return void
     */
    public function CropAlignment(string $a)
    {
        $this->updateURL(['a' => $a]);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $mask
     * @param boolean $trim
     * @param string $background
     * @return void
     */
    public function Mask(string $mask, bool $trim = false, string $background = '')
    {
        $this->updateURL(['mask' => $mask]);

        if ($trim) $this->updateURL('mtrim');

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param mixed $or
     * @return void
     */
    public function Orientation(mixed $or)
    {   
        if ($or === 'auto' || $or % 90 === 0)
        {
            $this->updateURL(['or' => $or]);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $bri
     * @return void
     */
    public function Brightness(int $bri)
    {
        if ($bri >= -100 && $bri <= 100)
        {
            $this->updateURL(['bri' => $bri]);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $con
     * @return void
     */
    public function Contrast(int $con)
    {
        if ($con >= -100 && $con <= 100)
        {
            $this->updateURL(['con' => $con]);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param float $gam
     * @return void
     */
    public function Gamma(float $gam = 2.2)
    {
        if ($gam >= 1 && $gam <= 3)
        {
            $this->updateURL(['gam' => $gam]);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param float $f
     * @param float $j
     * @param integer $r
     * @return void
     */
    public function Sharpen(float $f = 1.0, float $j = 2.0, int $r = 0)
    {
        $this->updateURL(['sharp' => implode(',', [$f, $j, $r])]);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $trim
     * @return void
     */
    public function Trim(int $trim)
    {
        if ($trim >= 1 && $trim <= 254)
        {
            $this->updateURL(['trim' => $trim]);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $bg
     * @return void
     */
    public function Background(string $bg)
    {
        $this->updateURL(['bg' => $bg]);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $blur
     * @return void
     */
    public function Blur(int $blur = 0)
    {
        $this->updateURL(['blur' => $blur]);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $filt
     * @return void
     */
    public function Filter(string $filt)
    {
        $this->updateURL(['filt' => $filt]);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $q
     * @return void
     */
    public function Quality(int $q) 
    {
        $this->updateURL(['q' => $q]);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $output
     * @return void
     */
    public function Output(string $output)
    {
        $this->updateURL(['output' => $output]);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function Interlace()
    {
        $this->updateURL(['il' => 1]);

        return $this;
    }

    // /**
    //  * @return SilverStripe\ORM\FieldType\DBHTMLText
    //  */
    // public function forTemplate()
    // {
    //     return $this->renderWith(self::class);
    // }

}
