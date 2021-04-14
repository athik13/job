<?php


namespace App\Models;

use App\Models\Traits\VerifiedTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prologue\Alerts\Facades\Alert;

class BaseUser extends Authenticatable
{
    use VerifiedTrait;

    public static $msg = 'demo_mode_message';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param array $attributes
     * @return $this|bool|\Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {
        if (isDemo()) {
            if (isFromAdminPanel()) {
                Alert::info(t(self::$msg))->flash();
            } else {
                flash(t(self::$msg))->info();
            }

            return false;
        } else {
            return static::query()->create($attributes);
        }
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        if (!$this->exists) {
            return false;
        }

        if (isDemo()) {
            if (isset($options['canBeUpdated']) && $options['canBeUpdated'] == true) {
                unset($options['canBeUpdated']);
                return $this->fill($attributes)->save($options);
            }

            if (isFromAdminPanel()) {
                Alert::info(t(self::$msg))->flash();
            } else {
                flash(t(self::$msg))->info();
            }

            return false;
        } else {
            return $this->fill($attributes)->save($options);
        }
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if (isDemo()) {
            if (isset($options['canBeSaved']) && $options['canBeSaved'] == true) {
                unset($options['canBeSaved']);
                return parent::save($options);
            }

            if (isFromAdminPanel()) {
                Alert::info(t(self::$msg))->flash();
            } else {
                flash(t(self::$msg))->info();
            }

            return false;
        } else {
            try {
                return parent::save($options);
            } catch (\Exception $e) {
                $msg = preg_replace('/\(SQL(.+)/xs', '', $e->getMessage());

                if (isFromAdminPanel()) {
                    Alert::error($msg)->flash();
                } else {
                    flash($msg)->error();
                }

                return false;
            }
        }
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        if (isDemo()) {
            if (isFromAdminPanel()) {
                Alert::info(t(self::$msg))->flash();
            } else {
                flash(t(self::$msg))->info();
            }

            return false;
        } else {
            return parent::delete();
        }
    }
}
