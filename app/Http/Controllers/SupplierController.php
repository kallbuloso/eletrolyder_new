<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\SupplierService;
use App\Http\Requests\PhoneRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\SupplierRequest;

/**
 * Class SupplierController
 * @package App\Http\Controllers
 */
class SupplierController extends Controller
{
    /**
     * Supplier Service
     * @var SupplierService
     */
    private $service;

    /**
     * Page Title
     * @var string
     */
    private $pageTitle = 'Fornecedores';

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Fornecedor';

    /**
     * Summary of pageIndex
     * @var string
     */
    private $pageIndex = 'registers.supplier.index';

    /**
     * Summary of pathView
     * @var string
     */
    private $pathView = 'Registers/Supplier';

    /**
     * SupplierController constructor.
     * @param SupplierService $service
     */
    public function __construct(SupplierService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse|\Inertia\Response
    {
        $this->authorize('supplier listar');

        try {
            $query = Supplier::query();
            $fields = Supplier::getSearchable();
            $query = $this->service->applyFilters($query, $request, $fields);
            $data = $query->paginate($request->get('limit', 10));

            if ($request->wantsJson()) {
                return response()->json($data);
            }

            return $this->renderPage("$this->pathView/Index", [
                'title' => $this->pageTitle,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'href' => route('dashboard')],
                    ['title' => $this->pageTitle, 'disabled' => true],
                ],
                'suppliersCount' => $this->service->count(),
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Momentum\Modal\Modal
     */
    public function create(): \Momentum\Modal\Modal
    {
        $this->authorize('supplier criar');

        return $this->renderModal("$this->pathView/Create")
            ->with([
                'title' => "Adicionar $this->titleSingular",
            ])
            ->baseRoute($this->pageIndex);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SupplierRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SupplierRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('supplier criar');

        $supplier = $this->service->create($request->validated());

        if ($request->phones != []) {
            foreach ($request->phones as $phone) {
                $supplier->phones()->create([
                    'phone_type' => $phone['phone_type'],
                    'phone_number' => $phone['phone_number'],
                    'phone_has_whatsapp' => $phone['phone_has_whatsapp'],
                    'phone_contact' => $phone['phone_contact'],
                ]);
            }
        }

        if ($request->addresses != []) {
            foreach ($request->addresses as $address) {
                $supplier->addresses()->create([
                    'type' => $address['type'],
                    'street' => $address['street'],
                    'number' => $address['number'],
                    'complement' => $address['complement'],
                    'neighborhood' => $address['neighborhood'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'country' => $address['country'],
                    'zip_code' => $address['zip_code'],
                    'reference' => $address['reference'],
                ]);
            }
        }

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular criado.", 'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PhoneRequest  $request
     * @param  $supplierId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePhone(PhoneRequest $request, $supplierId): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('phone criar');

        $supplier = $this->service->getById($supplierId);

        $supplier->phones()->create([
            'phone_type' => $request->phone_type,
            'phone_number' => $request->phone_number,
            'phone_contact' => $request->phone_contact,
            'phone_has_whatsapp' => $request->phone_has_whatsapp,
        ]);
        return redirect()->back()
            ->toast("Telefone adicionado ao $this->titleSingular.", 'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddressRequest  $request
     * @param  $supplierId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAddress(AddressRequest $request, $supplierId): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('address criar');

        $supplier = $this->service->getById($supplierId);

        $supplier->addresses()->create([
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
            ->toast("Endereço adicionado ao $this->titleSingular.", 'success');
    }

    /**
     * Display the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show($id): \Inertia\Response
    {
        $this->authorize('supplier ver');

        return $this->renderPage("$this->pathView/Show", [
            'title' => 'Detalhes de ' . $this->titleSingular,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'href' => route('dashboard')],
                ['title' => $this->pageTitle, 'href' => route($this->pageIndex)],
                ['title' => 'Mostrar', 'disabled' => true],
            ],
            'data' => $this->service->getById($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function edit($id): \Inertia\Response
    {
        $this->authorize('supplier editar');

        $data = $this->service->getById($id);
        $phones = $data->phones;
        $addresses = $data->addresses;

        $title = "Detalhes do $this->titleSingular $data->name";

        return $this->renderPage("$this->pathView/Edit", [
            'title' => "Detalhes de $this->titleSingular",
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'href' => route('dashboard')],
                ['title' => $this->pageTitle, 'href' => route($this->pageIndex)],
                ['title' => $title, 'disabled' => true],
            ],
            'supplier' => $data,
            'phones' => $phones,
            'addresses' => $addresses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SupplierRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SupplierRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('supplier editar');

        $this->service->update($id, $request->validated());

        return redirect()->back()
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
        $this->authorize('supplier excluir');

        $this->service->deleteById($id);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
