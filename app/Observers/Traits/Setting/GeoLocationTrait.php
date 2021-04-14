<?php


namespace App\Observers\Traits\Setting;

trait GeoLocationTrait
{
    /**
     * Saved
     *
     * @param $setting
     */
    public function geoLocationSaved($setting)
    {
        $this->saveTheDefaultCountryCodeInSession($setting);
    }

    /**
     * If the Default Country is changed,
     * Then clear the 'country_code' from the sessions,
     * And save the new value in session.
     *
     * @param $setting
     */
    private function saveTheDefaultCountryCodeInSession($setting)
    {
        if (isset($setting->value['default_country_code'])) {
            session()->forget('country_code');
            session(['country_code' => $setting->value['default_country_code']]);
        }
    }
}
