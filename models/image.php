<?php

class Image
{
    private $file_name;
    private $path;
    private $validation_errors = array();
    protected $validation_rules = array(
        'img_format' => array('msg' => 'Невалиден формат на снимка.'),
        'img_size' => array('max' => 10485760, 'msg' => 'Размерът на снимката не трябва да е по-голям от 10MB')
    );

    public function __construct($dir, $file_name, $user_name)
    {
        $this->file_name = $file_name;
        $this->path = 'user_img' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $user_name . DIRECTORY_SEPARATOR;
    }

    public function getFullFileName()
    {
        return $this->path . $this->file_name;
    }

    public function getFileName()
    {
        return $this->file_name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getValidationErrors()
    {
        return $this->validation_errors;
    }

    public function uploadToServer()
    {
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $allowed_filetypes = array('.jpg', '.jpeg', '.png', '.gif');
            $ext = strtolower(substr($this->file_name, strpos($this->file_name, '.'), strlen($this->file_name) - 1));

            $valid = true;
            if (!in_array($ext, $allowed_filetypes)) {
                $this->validation_errors['img_format'] = $this->validation_rules['img_format']['msg'];
                $valid = false;
            }

            if (filesize($_FILES['image']['tmp_name']) > $this->validation_rules['img_size']['max']) {
                $this->validation_errors['img_size'] = $this->validation_rules['img_size']['msg'];
                $valid = false;
            }

            if ($valid) {
                if (!file_exists($this->path)) {
                    mkdir($this->path, 0777, true);
                }

                if (!file_exists($this->getFullFileName())) {
                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $this->path . $this->file_name)) {
                        trigger_error('Error in image upload.', E_USER_ERROR);
                    }
                }else{
                    $this->validation_errors['img-exists'] = "Съществува снимка със същото име";
                }
            }
        } else {
            trigger_error('No image file', E_USER_ERROR);
        }
    }

    public function resize($w, $h, $crop = FALSE)
    {
        $file = $this->path . $this->file_name;
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