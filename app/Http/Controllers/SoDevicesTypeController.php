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
  private $pageTitle = 'Tipo de Aparelhos';

  /**
   * Title Singular
   * @var string
   */
  private $titleSingular = 'Aparelho';

  /**
   * Summary of pageIndex
   * @var string
   */
  private $pageIndex = 'orders.settings.soDevicesType.index';

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
        'soDevicesTypeCount' => $this->service->count(),
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
    $this->authorize('soDevicesType criar');

    return $this->renderPage("$this->pathView/Create", [
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
   * @param  SoDevicesTypeRequest  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(SoDevicesTypeRequest $request): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevicesType criar');

    $this->service->create($request->validated());

    return redirect()->route($this->pageIndex)
      ->toast("$this->titleSingular criado.", 'success');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @return \Inertia\Response
   */
  public function edit($id): \Inertia\Response
  {
    $this->authorize('soDevicesType editar');

    return $this->renderPage("$this->pathView/Edit", [
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
   * @param  SoDevicesTypeRequest  $request
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(SoDevicesTypeRequest $request, $id): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevicesType editar');

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
    $this->authorize('soDevicesType excluir');

    $this->service->deleteById($id);

    return redirect()->route($this->pageIndex)
      ->toast("$this->titleSingular excluído.", 'success');
  }
}
