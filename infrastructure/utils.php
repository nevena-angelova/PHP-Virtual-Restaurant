<?php

class Utils
{

    public static function hashPass($pass, $username)
    {
        return md5(md5($username) . sha1($pass) . md5($pass));
    }

    public static function uploadImageToServer($dir, $errors){

        $filename = $_FILES['image']['name'];
        $path = 'user_img' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR. $_SESSION['username'] . DIRECTORY_SEPARATOR;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if (file_exists($path . $filename)) {
            $errors['img_exists'] = 'Съществува снимка със същото име.';
        }

        if (count($errors) === 0
            && move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename)
        ) {
            return $filename;
        }
    }


    public static function resizeImage($file, $w, $h, $crop = FALSE)
    {
        list($width, $height, $image_type) = getimagesize($file);
        $x = 0;
        $y = 0;

        //make a square
        if ($crop && $w == $h) {
            if ($width > $height) {
                $x = floor(($width - $height) / 2);
                $width = $height;
            } else {
                $y = floor(($height - $width) / 2);
                $height = $width;
            }
        } else {
            //depending on $ratio either $w or $h stays the same
            $ratio = max($width / $w, $height / $h);
            $w = $width / $ratio;
            $h = $height / $ratio;
        }

        $src = null;
        switch ($image_type) {
            case 1:
                $src = imagecreatefromgif($file);
                break;
            case 2:
                $src = imagecreatefromjpeg($file);
                break;
            case 3:
                $src = imagecreatefrompng($file);
                break;
            default:
                return '';
                break;
        }

        $dst = imagecreatetruecolor($w, $h);
        imagecopyresampled($dst, $src, 0, 0, $x, $y, $w, $h, $width, $height);

        ob_start();

        $result_img_type = null;
        switch ($image_type) {
            case 1:
                imagegif($dst);
                $result_img_type = 'image/gif';
                break;
            case 2:
                imagejpeg($dst);
                $result_img_type = 'image/jpeg';
                break;
            case 3:
                imagepng($dst);
                $result_img_type = 'image/png';
                break;
            default:
                return '';
                break;
        }

        imagedestroy($dst);

        $i = ob_get_clean();

        return 'data:' . $result_img_type . ';base64,' . base64_encode($i);

    }

}
