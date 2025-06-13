<?php

namespace App\Http\Controllers;

use App\Models\SoDevicesType;
use Illuminate\Http\Request;
use App\Http\Requests\SoDevicesTypeRequest;
use App\Services\SoDevicesTypeService;
use App\Http\Controllers\Controller;

/**
 * Class SoDevicesTypeController
 * @package App\Http\Controllers
 */
class SoDevicesTypeController extends Controller
{
  /**
   * SoDevicesType Service
   * @var SoDevicesTypeService
   */
  private $service;

  /**
   * Page Title
   * @var string
   */
  private $pageTitle = 'Tipos de Aparelhos';

  /**
   * Title Singular
   * @var string
   */
  private $titleSingular = 'Aparelho';

  /**
   * Summary of pageIndex
   * @var string
   */
  private $pageIndex = '';

  /**
   * Summary of routeBase
   * @var string
   */
  private $routeBase = 'orders.soSettings.soDevicesType.';

  /**
   * Summary of pathView
   * @var string
   */
  private $pathView = 'ServicesOrder/Settings/DevicesType';

  /**
   * SoDevicesTypeController constructor.
   * @param SoDevicesTypeService $service
   */
  public function __construct(SoDevicesTypeService $service)
  {
    $this->service = $service;
    $this->pageIndex = $this->routeBase . 'index';
  }

  /**
   * Display a listing of the resource.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\JsonResponse|\Inertia\Response
   */
  public function index(Request $request): \Illuminate\Http\JsonResponse|\Inertia\Response
  {
    $this->authorize('soDevicesType listar');

    try {
      $query = SoDevicesType::query();
      $fields = SoDevicesType::getSearchable();
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
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Momentum\Modal\Modal
   */
  public function create(): \Momentum\Modal\Modal
  {
    $this->authorize('soDevicesType criar');

    return $this->renderModal("$this->pathView/Create")
      ->with([
        'title' => "Adicionar $this->titleSingular",
        'routeDefault' => $this->routeBase,
      ])
      ->baseRoute($this->pageIndex);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  SoDevicesTypeRequest  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(SoDevicesTypeRequest $request): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevicesType criar');

    $val = $request->validated();

    $existingStatus = $this->service->where('description', $val['description'])
      ->where('tenant_id', session('tenant_id'))
      ->first();

    if ($existingStatus) {
      return redirect()->back()
        ->withErrors(['description' => 'Já existe um aparelho com essa descrição.'])
        ->withInput();
    }

    $this->service->create($val);

    return redirect()->route($this->pageIndex)
      ->toast("$this->titleSingular criado com sucesso.", 'success');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @return \Momentum\Modal\Modal
   */
  public function edit($id): \Momentum\Modal\Modal
  {
    $this->authorize('soDevicesType editar');
    $data = $this->service->getById($id);

    return $this->renderModal("$this->pathView/Edit")
      ->with([
        'title' => "Editar $this->titleSingular",
        'data' => $data,
        'routeDefault' => $this->routeBase,
      ])
      ->baseRoute('orders.soSettings.soDevicesType.index');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  SoDevicesTypeRequest  $request
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(SoDevicesTypeRequest $request, $id): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevicesType editar');

    $val = $request->validated();

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
   *
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy($id): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevicesType excluir');

    $this->service->deleteById($id);

    return redirect()->route($this->pageIndex)
      ->toast("$this->titleSingular excluído.", 'success');
  }
}
