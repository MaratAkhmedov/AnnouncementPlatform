<?php
/**
 * Created by PhpStorm.
 * User: igugl
 * Date: 11/10/2019
 * Time: 22:15
 */

namespace App\Helpers\Image;


class ImageHelper
{
    private $image = null;

    function __construct($filePath)
    {
        // *** Open up the file
        $this->image = $this->openImage($filePath);
    }

    public function openImage($filePath)
    {
        // *** Get extension
        $extension = strtolower(strrchr($filePath, '.'));

        switch($extension)
        {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($filePath);
                break;
            case '.png':
                $img = @imagecreatefrompng($filePath);
                break;
            case '.gif':
                $img = @imagecreatefromgif($filePath);
                break;
            default:
                $img = false;
                break;
        }
        return $img;
    }

    public function scaleImage()
    {
        // Now resize the image width = 200 and height = 200
        $this -> image = imagescale($this->image, 300, 200);
    }

    public function saveImage($savePath, $imageQuality="100")
    {
        // *** Get extension
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

        switch($extension)
        {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    $response = imagejpeg($this->image, $savePath, $imageQuality);
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    $response = imagegif($this->image, $savePath);
                }
                break;

            case '.png':
                // *** Scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality/100) * 9);

                // *** Invert quality setting as 0 is best, not 9
                $invertScaleQuality = 9 - $scaleQuality;

                if (imagetypes() & IMG_PNG) {
                    $response = imagepng($this->image, $savePath, $invertScaleQuality);
                }
                break;

            // ... etc

            default:
                // *** No extension - No save.
                $response = false;
                break;
        }

        imagedestroy($this->image);
    }

    public function saveThumb($savePath, $imageQuality="100")
    {

    }

    public function getImage(){
        return $this -> image;
    }
}