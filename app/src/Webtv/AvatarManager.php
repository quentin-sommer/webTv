<?php

namespace Webtv;

use Illuminate\Support\Facades\App;

class AvatarManager
{

    protected $storagePath;
    /**
     * @var \Intervention\Image\ImageManager
     */
    protected $imgManager;
    /**
     * @var string
     */
    protected $encoding;
    /**
     * @var int
     */
    protected $width;
    /**
     * @var string
     */
    protected $default;

    public function __construct()
    {
        $this->storagePath = 'uploads/avatars';
        $this->imgManager = app('ImageManager');
        $this->encoding = 'jpg';
        $this->width = env('AVATAR_WIDTH');
        $this->default = 'default.jpg';
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return \Intervention\Image\ImageManager
     */
    public function getImgManager()
    {
        return $this->imgManager;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }


    public function processAvatar($path)
    {
        $manager = $this->imgManager->make($path);
        $manager->orientate();
        $manager->fit($this->width);
        $name = $this->getFileName();

        $manager->save($this->getUploadPath($name));

        return $name;
    }

    private function getFileName()
    {
        $path = time() . '_'
            . mt_rand() . '_'
            . mt_rand() . '.' . $this->encoding;

        return $path;
    }

    public function getUploadPath($name)
    {
        return App::basePath() . '/public/' . $this->storagePath . '/' . $name;
    }

    public function getUrl($name)
    {
        return url($this->storagePath . '/' . $name);
    }

    public function isNotDefault($name)
    {
        return $name !== $this->default;
    }
}