<?php

namespace Concrete\Package\HtmlMinifianaJones;

/**
 * Concrete5 HTML Minifiana Jones package controller
 * 
 * @author Markus Liechti <markus@liechti.io>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Controller extends \Concrete\Core\Package\Package
{
    protected $pkgHandle          = 'html_minifiana_jones';
    protected $appVersionRequired = '8.0.0';
    protected $pkgVersion         = '1.0.0';
    protected $pkgAutoloaderRegistries = array(
        'src/Kaapiii' => '\Kaapiii',
    );

    public function getPackageDescription()
    {
        return t("The package automatically compresses your HTML output.");
    }

    public function getPackageName()
    {
        return t("Html Minifiana Jones");
    }

    public function on_start()
    {
        $this->registerMiddleware();
    }

    /**
     * Register custom middleware
     */
    protected function registerMiddleware(){
        $server = $this->app->make(\Concrete\Core\Http\ServerInterface::class);
        $server->addMiddleware($this->app->make(\Kaapiii\Middleware\HtmlMinifyMiddleware::class),100);
    }
}

