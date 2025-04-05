<?php

namespace App\Http\Middleware;

use App\Facades\Toast;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->getRoleNames(),
                    'profile_photo_url' => $request->user()->profile_photo_url,
                    'permissions' => $request->user()->getAllPermissions()->pluck('name'),
                ] : null,
            ],
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'appName' => config('app.name'),
            'toasts' => Toast::all(),
        ];
    }

    // /**
    //  * Summary of getCompany
    //  * @return mixed
    //  */
    // protected function getCompany($request)
    // {
    //   if (!$request->session()->get('company')) {
    //     $company = Company::find(1)->only([
    //       'status',
    //       'name',
    //       'fantasy_name',
    //       'contact_name',
    //       'person',
    //       'cpf_cnpj',
    //       'rg_insc_est',
    //       'ccm',
    //       'birth_date',
    //       'logo',
    //       'description',
    //       'email',
    //       'website',
    //       'note',
    //       'created_at',
    //       'updated_at',
    //       'phones',
    //       'addresses',
    //     ]) ?? null;
    //     $request->session()->put('company', $company);
    //   }
    //   // dd($request->session()->get('company'));
    //   return $request->session()->get('company');
    // }
}
