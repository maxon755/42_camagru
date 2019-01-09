<?php

namespace app\base;

use Exception;

class View extends Application
{
    private static $viewInstance = null;

    private $template = ROOT . '/template/template.php';

    private $viewName;

    private $jsFiles = [];

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
     * @param $viewName
     * @return array
     */
    private function getViewFiles(): array
    {
        $pattern = $this->getViewPath() . $this->viewName;

        return ["markUp"    => ROOT . DS . $pattern . ".php",
            "style"     => $pattern . ".css",
            "script"    => $pattern . ".js"];
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
    public function registerJsFile(string $fileName): void
    {
        $this->jsFiles[] = $this->resolveFilePath($fileName, 'js');
    }

    /**
     * @param string $fileName
     * @throws Exception
     */
    public function registerCssFile(string $fileName)
    {
        $this->cssFiles[] = $this->resolveFilePath($fileName, 'css');
    }

    /**
     * @param string $fileName
     * @return string
     * @throws Exception
     */
    private function resolveFilePath(string $fileName, $extension)
    {
        if (!preg_match('/.+\.\w+$/', $fileName)) {
            $fileName = $fileName . '.' . $extension;
        }
        $pathPattenrs = [
            $this->getViewPath() . 'assets' . DS . $extension . DS . $fileName,
            $this->getViewPath() . 'assets' . DS . $fileName,
        ];
        foreach ($pathPattenrs as $pathPattern) {
            if (file_exists(ROOT . $pathPattern)) {
                return $pathPattern;
            }
        }
        throw new Exception("File ${fileName} does not exists");
    }
}
