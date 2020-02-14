<?php

namespace Core\Site;

use Core\Settings\Models\SettingsModel;

class Site {

    /**
     * Site config
     *
     * Image sizes
     * File types allowed
     * Fie & image sizes & extensions
     * Header & footer scripts?
     * Admin email?

     * Theme MENUS
     */


    /**
     * Theme config from path.
     *
     * @var
     */
    protected $siteConfig;

    /**
     * Settings model.
     *
     * @var
     */
    protected $settings;

    /**
     * Site constructor.
     *
     * @param SettingsModel $settingsModel
     */
    public function __construct(SettingsModel $settingsModel)
    {
        $this->settings = $settingsModel;
    }

    /**
     * @return bool|mixed
     */
    public function get()
    {
        $site = $this->settings->getValueByName('site_config');

        if (!$site) {
            throw new SiteConfigException('The site\'s config file has not been found');
        }

        return $site;
    }

    /**
     * Checks if the current site configuration file is
     * the same as the one stored in the database.
     *
     * @return bool
     */
    private function check()
    {
        $existingSiteConfig = unserialize($this->settings->getValueByName('site_config') ?? []);

        if ($existingSiteConfig != $this->siteConfig || !isset($existingSiteConfig)) {
            return false;
        }

        return true;
    }


}
