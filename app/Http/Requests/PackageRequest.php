<?php


namespace App\Http\Requests;

use App\Models\Package;
use App\Models\PaymentMethod;

class PackageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        // Get all the Packages & Payment Methods in the database
        $countPackages = Package::count();
        $countPaymentMethods = PaymentMethod::count();

        // Check if 'package_id' & 'payment_method_id' are required
        if ($countPackages > 0 && $countPaymentMethods > 0) {
            // Require 'package_id' if Packages are available
            $rules['package_id'] = ['required'];

            // Require 'payment_method_id' if the Package 'price' > 0
            if ($this->filled('package_id')) {
                $package = Package::find($this->input('package_id'));
                if (!empty($package) && $package->price > 0) {
                    $rules['payment_method_id'] = ['required', 'not_in:0'];
                }
            }
        }

        return $rules;
    }
}