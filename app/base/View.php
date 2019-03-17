<?php

namespace app\base;

use Exception;

class View extends Application
{
    /** @var \app\base\View  */
    private static $viewInstance;

    /** @var string  */
    private $template = ROOT . '/template/template.php';

    /** @var string */
    private $viewName;

    /** @var string[] */
    private $jsFiles = [];

    /** @var string[]  */
    private $jsScripts = [];

    /** @var string[]  */
    private $cssFiles = [];

    private function __construct()
    {
    }

    /**
     * @return View
     */
    public static function getInstance(): View
    {
        if (!self::$viewInstance) {
            self::$viewInstance = new self();
        }

        return self::$viewInstance;
    }

    /**
     * @return array
     */
    private function getViewFiles(): array
    {
        $pattern = $this->getViewPath() . $this->viewName;

        $style = $pattern . ".css";
        if (!file_exists(ROOT . DS . $style)) {
            $style = false;
        }
        $script = $pattern . ".js";
        if (!file_exists(ROOT . DS . $script)) {
            $script = false;
        }
        return ["markUp"    => ROOT . DS . $pattern . ".php",
            "style"     => $style,
            "script"    => $script];
    }

    /**
     * @return string
     */
    private function getViewPath(): string
    {
        return DS . "views" . DS . $this->viewName . DS ;
    }

    /**
     * @param string $viewName
     * @param bool $useComponents
     * @param array $parameters
     */
    public function render(
        string $viewName,
        bool $useComponents,
        array $parameters = []
    ): void {
        $this->viewName = $viewName;
        $renderUnit = $this->getViewFiles();
        include($this->template);
    }

    /**
     * @param string $fileName
     * @throws Exception
     */
    public function registerJsFile(string $fileName, bool $fullPath = false): void
    {
        $filePath = $fullPath ?
                    $this->checkFilePath($fileName) :
                    $this->resolveFilePath($fileName, 'js');
        if (!in_array($filePath, $this->jsFiles)) {
            $this->jsFiles[] = $filePath;
        }
    }

    /**
     * @param string $fileName
     * @param bool $fullPath
     * @throws Exception
     */
    public function registerCssFile(string $fileName, bool $fullPath = false): void
    {
        $filePath = $fullPath ?
                    $this->checkFilePath($fileName) :
                    $this->resolveFilePath($fileName, 'css');
        if (!in_array($filePath, $this->cssFiles)) {
            $this->cssFiles[] = $filePath;
        }
    }

    /**
     * @param string $path
     * @return string
     * @throws Exception
     */
    public function checkFilePath(string $path): ?string
    {
        if (realpath(ROOT . DS . $path)) {
            return $path;
        }
        throw new Exception("File ${$path} does not exists");
    }

    /**
     * @param string $fileName
     * @param string $extension
     * @return string
     * @throws Exception
     */
    private function resolveFilePath(string $fileName, string $extension): ?string
    {
        if (!preg_match('/.+\.\w+$/', $fileName)) {
            $fileName = $fileName . '.' . $extension;
        }
        $pathPatterns = [
            $this->getViewPath() . $fileName,
            $this->getViewPath() . $extension . DS . $fileName,
            $this->getViewPath() . 'assets' . DS . $extension . DS . $fileName,
            $this->getViewPath() . 'assets' . DS . $fileName,
        ];
        foreach ($pathPatterns as $pathPattern) {
            if (file_exists(ROOT . $pathPattern)) {
                return $pathPattern;
            }
        }
        throw new Exception("File ${fileName} does not exists");
    }

    /**
     * @param string $jsScript
     */
    public function registerJsScript(string $jsScript): void
    {
        $this->jsScripts[] = $jsScript;
    }
}
