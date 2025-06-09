<?php

namespace App\Http\Controllers;

use App\Models\SoStatusStep;
use App\Models\SoStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SoStatusStepRequest;
use App\Http\Requests\PhoneRequest;
use App\Http\Requests\AddressRequest;
use App\Services\SoStatusStepService;
use App\Http\Controllers\Controller;

/**
 * Class SoStatusStepController
 * @package App\Http\Controllers
 */
class SoStatusStepController extends Controller
{
  /**
   * SoStatusStep Service
   * @var SoStatusStepService
   */
  private $service;

  /**
   * Page Title
   * @var string
   */
  private $pageTitle = 'Passos de Status de Ordens de Serviço';

  /**
   * Title Singular
   * @var string
   */
  private $titleSingular = 'Passo de Status de Ordem de Serviço';

  /**
   * Summary of pageIndex
   * @var string
   */
  private $pageIndex = 'orders.statusStep.index';

  /**
   * Summary of pathView
   * @var string
   */
  private $pathView = 'ServicesOrder/StatusStep';

  /**
   * SoStatusStepController constructor.
   * @param SoStatusStepService $service
   */
  public function __construct(SoStatusStepService $service)
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
   *
   * @return \Momentum\Modal\Modal
   */
  public function create(): \Momentum\Modal\Modal
  {
    $this->authorize('soStatusStep criar');

    return $this->renderModal("$this->pathView/Create")
      ->with([
        'title' => "Adicionar $this->titleSingular",
      ])
      ->baseRoute($this->pageIndex);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  SoStatusStepRequest  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(SoStatusStepRequest $request): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soStatusStep criar');

    $this->service->create($request->validated());

    return redirect()->route($this->pageIndex)
      ->toast("$this->titleSingular criado.", 'success');
  }

  /**
   * Display the specified resource.
   *
   * @return \Inertia\Response
   */
  public function show($id): \Inertia\Response
  {
    $this->authorize('soStatusStep ver');

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
    $this->authorize('soStatusStep editar');

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
   * @param  SoStatusStepRequest  $request
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(SoStatusStepRequest $request, $id): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soStatusStep editar');

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
    $this->authorize('soStatusStep excluir');

    $this->service->deleteById($id);

    return redirect()->route($this->pageIndex)
      ->toast("$this->titleSingular excluído.", 'success');
  }
}
