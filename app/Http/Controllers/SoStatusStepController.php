<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoStatusStepRequest;
use App\Models\SoStatus;
use App\Models\SoStatusStep;
use App\Services\SoStatusStepService;
use Illuminate\Http\Request;

/**
 * Class SoStatusStepController
 */
class SoStatusStepController extends Controller
{
    /**
     * SoStatusStep Service
     *
     * @var SoStatusStepService
     */
    private $service;

    /**
     * Page Title
     *
     * @var string
     */
    private $pageTitle = 'Andamento de Status de OS';

    /**
     * Title Singular
     *
     * @var string
     */
    private $titleSingular = 'Andamento de Status';

    /**
     * Summary of pageIndex
     *
     * @var string
     */
    private $pageIndex = 'orders.soSettings.statusStep.index';

    /**
     * Summary of pathView
     *
     * @var string
     */
    private $pathView = 'ServicesOrder/Settings/StatusStep';

    /**
     * SoStatusStepController constructor.
     */
    public function __construct(SoStatusStepService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse|\Inertia\Response
    {
        $this->authorize('soStatusStep listar');

        // dd($this->service->count());

        try {
            $query = SoStatusStep::query();
            $status = null;

            if ($request->filled('so_status_id')) {
                $query->where('so_status_id', $request->get('so_status_id'));
                $status = SoStatus::find($request->get('so_status_id'));
            }

            // dd(SoStatusStep::query());

            $fields = SoStatusStep::getSearchable();
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
                'soStatusStepCount' => $this->service->count(),
                'status' => $status,
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
     */
    public function create($id): \Momentum\Modal\Modal
    {
        $this->authorize('soStatusStep criar');

        // dd($id);

        return $this->renderModal("$this->pathView/Create")
            ->with([
                'title' => "Adicionar $this->titleSingular",
                'soStatusId' => $id,
            ])
            ->baseRoute('orders.soSettings.soStatus.edit', $id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SoStatusStepRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('soStatusStep criar');

        $val = $request->validated();

        $existingStatus = $this->service->where('description', $val['description'])
            ->where('tenant_id', session('tenant_id'))
            ->where('so_status_id', $val['so_status_id'], '=') // Corrected to access the so_status_id from $val
            ->first();

        if ($existingStatus) {
            return redirect()->back()
                ->withErrors(['description' => 'Já existe um andamento com essa descrição.'])
                ->withInput();
        }

        $status = $this->service->create($val);

        return redirect()->route('orders.soSettings.soStatus.edit', $status->so_status_id)
            ->toast("$this->titleSingular criado.", 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): \Momentum\Modal\Modal
    {
        $this->authorize('soStatusStep editar');
        $data = $this->service->getById($id);

        return $this->renderModal("$this->pathView/Edit")
            ->with([
                'title' => "Editar $this->titleSingular",
                'data' => $data,
            ])
            ->baseRoute('orders.soSettings.soStatus.edit', $data['so_status_id']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SoStatusStepRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('soStatusStep editar');

        $val = $request->validated();

        $existingStatus = $this->service->where('description', $val['description'])
            ->where('tenant_id', session('tenant_id'))
            ->where('id', $id, '!=')
            ->where('so_status_id', $val['so_status_id'], '=') // Corrected to access the so_status_id from $val
            ->first();

        if ($existingStatus) {
            return redirect()->back()
                ->withErrors(['description' => 'Já existe um andamento com essa descrição.'])
                ->withInput();
        }

        $this->service->update($id, $val);
        // dd($status);

        return redirect()->route('orders.soSettings.soStatus.edit', $val['so_status_id'])
            ->toast("$this->titleSingular atualizado.", 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($redirect, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('soStatusStep excluir');

        $this->service->deleteById($id);

        return redirect()->route('orders.soSettings.soStatus.edit', $redirect)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
