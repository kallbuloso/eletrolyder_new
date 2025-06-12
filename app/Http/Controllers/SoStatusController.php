<?php

namespace App\Http\Controllers;

use App\Models\SoStatus;
use Illuminate\Http\Request;
use App\Services\SoStatusService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SoStatusRequest;
use App\Http\Requests\SoStatusUpdateRequest;

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
    private $pageTitle = 'Status de Ordens de Serviço';

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Status de Ordem de Serviço';

    /**
     * Summary of pageIndex
     * @var string
     */
    private $pageIndex = 'orders.soSettings.soStatus.index';

    /**
     * Summary of pathView
     * @var string
     */
    private $pathView = 'ServicesOrder/Settings/Statuses';

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
            // dd($data->toArray());
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
     * @return \Momentum\Modal\Modal
     */
    public function create(): \Momentum\Modal\Modal
    {
        $this->authorize('soStatus criar');

        return $this->renderModal("$this->pathView/Create")
            ->with([
                'title' => "Adicionar $this->titleSingular",
            ])
            ->baseRoute($this->pageIndex);
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

        $val = $request->validated();

        $existingStatus = $this->service->where('description', $val['description'])
            ->where('tenant_id', session('tenant_id'))
            ->first();

        if ($existingStatus) {
            return redirect()->back()
                ->withErrors(['description' => 'Já existe um status com essa descrição.'])
                ->withInput();
        }

        $status = $this->service->create($val);

        return redirect()->route($this->pageIndex)
            ->toast("Status criado com sucesso.", 'success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function edit($id): \Inertia\Response
    {
        $this->authorize('soStatus editar');

        return $this->renderPage("$this->pathView/Edit", [
            'title' => "Editando $this->titleSingular",
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'href' => route('dashboard')],
                ['title' => $this->pageTitle, 'href' => route($this->pageIndex)],
                ['title' => 'Editar', 'disabled' => true],
            ],
            'title' => "Editando $this->titleSingular",
            'data' => $this->service->getById($id),
            'statusSteps' => $this->service->getById($id)->statusSteps()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoStatusRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SoStatusUpdateRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('soStatus editar');

        $val = $request->validated();

        $existingStatus = $this->service->where('description', $val['description'])
            ->where('tenant_id', session('tenant_id'))
            ->where('id', $id, '!=')
            ->first();

        if ($existingStatus) {
            return redirect()->back()
                ->withErrors(['description' => 'Já existe um status com essa descrição.'])
                ->withInput();
        }

        $this->service->update($id, $val);

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
