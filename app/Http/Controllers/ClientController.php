<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Requests\PhoneRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\AddressRequest;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends Controller
{
    /**
     * Client Service
     * @var ClientService
     */
    private $service;

    /**
     * Page Title
     * @var string
     */
    private $pageTitle = 'Clientes';

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Cliente';

    /**
     * Summary of pageIndex
     * @var string
     */
    private $pageIndex = 'registers.client.index';

    /**
     * Summary of pathView
     * @var string
     */
    private $pathView = 'Registers/Client';

    /**
     * ClientController constructor.
     * @param ClientService $service
     */
    public function __construct(ClientService $service)
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
        $this->authorize('client listar');

        try {
            $query = Client::query();
            $query = $this->service->applyFilters($query, $request, ['name', 'nick_name', 'cpf_cnpj']);
            $clients = $query->paginate($request->get('limit', 10));

            if ($request->wantsJson()) {
                return response()->json($clients);
            }

            return $this->renderPage("$this->pathView/Index", [
                'title' => $this->pageTitle,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'href' => route('dashboard')],
                    ['title' => $this->pageTitle, 'disabled' => true],
                ],
                'clientsCount' => $this->service->count(),
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
        $this->authorize('client criar');

        return $this->renderModal("$this->pathView/Create")
            ->with([
                'title' => "Adicionar $this->titleSingular",
            ])
            ->baseRoute($this->pageIndex);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('client criar');

        $client = $this->service->create($request->validated());

        if ($request->phones != []) {
            foreach ($request->phones as $phone) {
                $client->phones()->create([
                    'phone_type' => $phone['phone_type'],
                    'phone_number' => $phone['phone_number'],
                    'phone_has_whatsapp' => $phone['phone_has_whatsapp'],
                    'phone_contact' => $phone['phone_contact'],
                ]);
            }
        }

        if ($request->addresses != []) {
            foreach ($request->addresses as $address) {
                $client->addresses()->create([
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
     * @param  $clientId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePhone(PhoneRequest $request, $clientId): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('phone criar');

        $client = $this->service->getById($clientId);

        $client->phones()->create([
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
     * @param  $clientId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAddress(AddressRequest $request, $clientId): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('address criar');

        $client = $this->service->getById($clientId);

        $client->addresses()->create([
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
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function edit($id): \Inertia\Response
    {
        $this->authorize('client editar');

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
            'client' => $data,
            'phones' => $phones,
            'addresses' => $addresses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('client editar');

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
        $this->authorize('client excluir');

        $this->service->deleteById($id);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
