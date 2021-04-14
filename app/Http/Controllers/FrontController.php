<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CommonTrait;
use App\Http\Controllers\Traits\RobotsTxtTrait;
use App\Http\Controllers\Traits\SettingsTrait;

class FrontController extends Controller
{
    use SettingsTrait, RobotsTxtTrait, CommonTrait;

    public $request;
    public $data = [];

    /**
     * FrontController constructor.
     */
    public function __construct()
    {
        // Set the storage disk
        $this->setStorageDisk();

        // Check & Change the App Key (If needed)
        $this->checkAndGenerateAppKey();

        // Load the Plugins
        $this->loadPlugins();

        // From Laravel 5.3.4+
        $this->middleware(function ($request, $next) {
            // Load Localization Data first
            // Check out the SetCountryLocale Middleware
            $this->checkDotEnvEntries();
            $this->applyFrontSettings();
            $this->checkRobotsTxtFile();

            return $next($request);
        });

        // Check the 'Domain Mapping' plugin
        if (config('plugins.domainmapping.installed')) {
            $this->middleware(['domain.verification']);
        }
    }
}
