<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceOrderRequest;
use App\Models\ServiceOrder;
use App\Services\ServiceOrderService;
use Illuminate\Http\Request;

/**
 * Class ServiceOrderController
 */
class ServiceOrderController extends Controller
{
    /**
     * ServiceOrder Service
     *
     * @var ServiceOrderService
     */
    private $service;

    /**
     * Page Title
     *
     * @var string
     */
    private $pageTitle = 'Ordens de Serviço';

    /**
     * Title Singular
     *
     * @var string
     */
    private $titleSingular = 'Ordem de Serviço';

    /**
     * Summary of pageIndex
     *
     * @var string
     */
    private $pageIndex = '';

    /**
     * Summary of routeBase
     *
     * @var string
     */
    private $routeBase = 'orders.serviceOrder.';

    /**
     * Summary of pathView
     *
     * @var string
     */
    private $pathView = 'ServicesOrder/So';

    /**
     * ServiceOrderController constructor.
     */
    public function __construct(ServiceOrderService $service)
    {
        $this->service = $service;
        $this->pageIndex = $this->routeBase.'index';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse|\Inertia\Response
    {
        $this->authorize('serviceOrder listar');

        try {
            $query = ServiceOrder::query();
            $fields = ServiceOrder::getSearchable();
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
                'count' => $this->service->count(),
                'routeDefault' => $this->routeBase,
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            throw $e;
        }

        // $query = ServiceOrder::query();
        // $query = $this->service->applyFilters($query, $request);
        // $data = $query->paginate($request->get('limit', 10));
        // return $this->renderPage("$this->pathView/Index", [
        //   'title' => $this->pageTitle,
        //   'breadcrumbs' => [
        //     ['title' => 'Dashboard', 'href' => route('dashboard')],
        //     ['title' => $this->pageTitle, 'disabled' => true],
        //   ],
        //   'data' => $data,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Momentum\Modal\Modal
    {
        $this->authorize('serviceOrder criar');

        return $this->renderModal("$this->pathView/Create")
            ->with([
                'title' => "Adicionar $this->titleSingular",
                'routeDefault' => $this->routeBase,
            ])
            ->baseRoute($this->pageIndex);

        // return $this->renderPage("$this->pathView/Form", [
        //   'title' => "Adicionar $this->titleSingular",
        //   'breadcrumbs' => [
        //     ['title' => 'Dashboard', 'href' => route('dashboard')],
        //     ['title' => $this->pageTitle, 'href' => route($this->pageIndex)],
        //     ['title' => 'Adicionar', 'disabled' => true],
        //   ],
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceOrderRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('serviceOrder criar');

        $val = $request->validated();

        // Todo: ajustar nome da validação
        $existingStatus = $this->service->where('order_number', $val['order_number'])
            ->where('tenant_id', session('tenant_id'))
            ->first();

        if ($existingStatus) {
            return redirect()->back()
                ->withErrors(['description' => 'Já existe um aparelho com essa descrição.'])
                ->withInput();
        }

        $this->service->create($val);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular adicionado com sucesso.", 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): \Inertia\Response
    {
        $this->authorize('serviceOrder ver');

        return $this->renderPage("$this->pathView/Show", [
            'title' => 'Detalhes de '.$this->titleSingular,
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
     */
    public function edit($id): \Momentum\Modal\Modal
    {
        $this->authorize('serviceOrder editar');

        $data = $this->service->getById($id);

        return $this->renderModal("$this->pathView/Edit")
            ->with([
                'title' => "Editar $this->titleSingular",
                'data' => $data,
                'routeDefault' => $this->routeBase,
            ])
            ->baseRoute($this->pageIndex);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceOrderRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('serviceOrder editar');

        $val = $request->validated();

        // Todo: Ajustar validação
        $existingStatus = $this->service->where('description', $val['description'])
            ->where('tenant_id', session('tenant_id'))
            ->where('id', $id, '!=')
            ->first();

        if ($existingStatus) {
            return redirect()->back()
                ->withErrors(['description' => 'Já existe um aparelho com essa descrição.'])
                ->withInput();
        }

        $this->service->update($id, $val);

        return redirect()->back()
            ->toast("$this->titleSingular atualizado.", 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('serviceOrder excluir');

        $this->service->deleteById($id);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
