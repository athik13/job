<?php


namespace App\Http\Controllers\Account;

use App\Helpers\UrlGen;
use App\Models\Permission;
use App\Models\User;

class CloseController extends AccountBaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        view()->share('pagePath', 'close');

        return appView('account.close');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function submit()
    {
        if (request()->input('close_account_confirmation') == 1) {
            // Get User
            $user = User::findOrFail(auth()->user()->id);

            // Don't delete admin users
            if ($user->can(Permission::getStaffPermissions())) {
                flash(t('admin_users_cannot_be_deleted'))->error();

                return redirect('account');
            }

            // Delete User
            $user->delete();

            // Close User's session
            auth()->logout();

            $message = t('your_account_has_been_deleted_2', ['url' => UrlGen::register()]);
            flash($message)->success();
        }

        return redirect('/');
    }
}
