<?php

namespace App\Http\Controllers;

use App\Models\SoStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SoStatusRequest;
use App\Http\Requests\PhoneRequest;
use App\Http\Requests\AddressRequest;
use App\Services\SoStatusService;
use App\Http\Controllers\Controller;

/**
 * Class SoStatusController
 * @package App\Http\Controllers
 */
class SoStatusController extends Controller
{
    /**
     * SoStatus Service
     * @var SoStatusService
     */
    private $service;

    /**
     * Page Title
     * @var string
     */
    private $pageTitle = 'SoStatus';

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'SoStatus';

    /**
     * Summary of pageIndex
     * @var string
     */
    private $pageIndex = 'orders.soStatus.index';

    /**
     * Summary of pathView
     * @var string
     */
    private $pathView = 'ServicesOrder/Statuses';

    /**
     * SoStatusController constructor.
     * @param SoStatusService $service
     */
    public function __construct(SoStatusService $service)
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
        $this->authorize('soStatus listar');



        try {
            $query = SoStatus::query();
            $fields = SoStatus::getSearchable();
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
                'soStatusCount' => $this->service->count(),
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
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        $this->authorize('soStatus criar');

        return $this->renderPage("$this->pathView/Form", [
            'title' => "Adicionar $this->titleSingular",
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'href' => route('dashboard')],
                ['title' => $this->pageTitle, 'href' => route($this->pageIndex)],
                ['title' => 'Adicionar', 'disabled' => true],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SoStatusRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SoStatusRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('soStatus criar');

        $this->service->create($request->validated());

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
    public function storePhone(PhoneRequest $request, $soStatusId): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('phone criar');

        $soStatus = $this->service->getById($soStatusId);

        $soStatus->phones()->create([
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
     * Display the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show($id): \Inertia\Response
    {
        $this->authorize('soStatus ver');

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
        $this->authorize('soStatus editar');

        return $this->renderPage("$this->pathView/Form", [
            'title' => "Editando $this->titleSingular",
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'href' => route('dashboard')],
                ['title' => $this->pageTitle, 'href' => route($this->pageIndex)],
                ['title' => 'Editar', 'disabled' => true],
            ],
            'data' => $this->service->getById($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoStatusRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SoStatusRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('soStatus editar');

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
        $this->authorize('soStatus excluir');

        $this->service->deleteById($id);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
