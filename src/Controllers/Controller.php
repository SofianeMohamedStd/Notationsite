<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    private const CONFIG = __DIR__ . '/../core/config.json';
    protected static $_twig = null;
    protected static $_baseUrl = null;


    public function __construct()
    {
        $this->twig = self::getTwig();
        $this->baseUrl = self::getBaseUrl();
    }

    protected static function getTwig()
    {

        if (is_null(self::$_twig)) {
            $loader = new FilesystemLoader('src/Views');
            self::$_twig = new Environment($loader, [
            'debug' => true,
            'cache' => false
            ]);
            self::$_twig->addExtension(new \Twig\Extension\DebugExtension());
            self::$_twig->addGlobal('baseUrl', self::getBaseUrl());
        }

        return self::$_twig;
    }

    protected static function getBaseUrl()
    {
        if (is_null(self::$_baseUrl)) {
            $config = json_decode(file_get_contents(self::CONFIG));
            self::$_baseUrl = $config->baseUrl;
        }
        return self::$_baseUrl;
    }
}
