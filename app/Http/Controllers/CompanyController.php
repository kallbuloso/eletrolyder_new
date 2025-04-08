<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Requests\PhoneRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\CompanyRequest;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * Company Service
     * @var CompanyService
     */
    private $service;

    /**
     * Page Title
     * @var string
     */
    private $pageTitle = 'Company';

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Company';

    /**
     * Summary of pageIndex
     * @var string
     */
    private $pageIndex = 'settings.company.index';

    /**
     * CompanyController constructor.
     * @param CompanyService $service
     */
    public function __construct(CompanyService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $this->authorize('company ver');

        $company = $this->service
            ->where('tenant_id', session('tenant_id'))
            ->first();

        if (!$company) {
            return redirect()->back()
                ->toast('Não foi possível encontrar a empresa.', 'error');
        } else {
            $phones = $company->phones;
            $addresses = $company->addresses;

            return $this->renderPage('Settings/Company/Index', [
                'title' => $this->pageTitle,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'href' => route('dashboard')],
                    ['title' => $this->pageTitle, 'disabled' => true],
                ],
                'company' => $company,
                'phones' => $phones,
                'addresses' => $addresses,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PhoneRequest  $request
     * @param  $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePhone(PhoneRequest $request, $companyId): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('phone criar');

        $company = $this->service->getById($companyId);

        $company->phones()->create([
            'tenant_id' => session('tenant_id'),
            'phone_type' => $request->phone_type,
            'phone_number' => $request->phone_number,
            'phone_contact' => $request->phone_contact,
            'phone_has_whatsapp' => $request->phone_has_whatsapp,
        ]);

        return redirect()->back()
            ->toast("Telefone adicionado à empresa.", 'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddressRequest  $request
     * @param  $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAddress(AddressRequest $request, $companyId): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('address criar');

        $company = $this->service->getById($companyId);

        $company->addresses()->create([
            'tenant_id' => session('tenant_id'),
            'type' => $request->type,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'neighborhood' => $request->neighborhood,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'reference' => $request->reference,
        ]);

        return redirect()->back()
            ->toast("Endereço adicionado à empresa.", 'success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CompanyRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('company editar');

        $this->service->update($id, $request->validated());

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular atualizado.", 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('company excluir');

        $this->service->deleteById($id);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
