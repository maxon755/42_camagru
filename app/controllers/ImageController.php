<?php

namespace app\controllers;

use app\base\Controller;
use app\models\Post;


class ImageController extends Controller
{
    private const VIEW_NAME = 'image';

    private $extension = 'jpeg';

    private $postModel;

    private $userId;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userId = self::$auth->getUserId();
    }

    public function actionIndex()
    {
        $this->render($this::VIEW_NAME, true);
    }

    public function actionSave()
    {
        $image = $_REQUEST['image'] ?? null;
        if (!$image) {
            return;
        }

        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));

        $path = $this->getImagePath();
        $imageNumber = $this->getImageNumber();
        $imageName = $this->getImageName($imageNumber);

        $fullPath = $path . DS . $imageName;

        echo $this->postModel->insertImageData($this->userId, $imageName, $imageNumber) &&
        file_put_contents($fullPath, $image);
    }

    /**
     * @return string
     */
    private function getImagePath(): string
    {
        $path = self::$config['storage'] . DS . 'images' . DS . $this->userId;

        if (!file_exists($path)) {
            mkdir($path);
            chmod($path, 0777);
        }

        return $path;
    }

    /**
     * @return int
     */
    public function getImageNumber(): int
    {
        return $this->postModel->getMaxImageNumber($this->userId) + 1;
    }

    /**
     * @param string $path
     * @return string
     */
    private function getImageName($imageNumber): string
    {
        return $imageNumber . '.' .$this->extension;
    }
}