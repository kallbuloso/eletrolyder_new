<?php

namespace App\Http\Controllers;

use App\Models\SoDevice;
use Illuminate\Http\Request;
use App\Http\Requests\SoDeviceRequest;
use App\Services\SoDeviceService;
use App\Http\Controllers\Controller;

/**
 * Class SoDeviceController
 * @package App\Http\Controllers
 */
class SoDeviceController extends Controller
{
  /**
   * SoDevice Service
   * @var SoDeviceService
   */
  private $service;

  /**
   * Page Title
   * @var string
   */
  private $pageTitle = 'Equipamentos';

  /**
   * Title Singular
   * @var string
   */
  private $titleSingular = 'Equipamento';

  /**
   * Summary of pageIndex
   * @var string
   */
  private $pageIndex = '';

  /**
   * Summary of routeBase
   * @var string
   */
  private $routeBase = 'orders.soDevice.';

  /**
   * Summary of pathView
   * @var string
   */
  private $pathView = 'ServicesOrder/SoDevice';

  /**
   * SoDeviceController constructor.
   * @param SoDeviceService $service
   */
  public function __construct(SoDeviceService $service)
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
    $this->authorize('soDevice listar');

    // dd(SoDevice::query());

    try {
      $query = SoDevice::query();
      $fields = SoDevice::getSearchable();
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

    // $query = SoDevice::query();
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
   *
   * @return \Momentum\Modal\Modal
   */
  public function create(): \Momentum\Modal\Modal
  {
    $this->authorize('soDevice criar');

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
   *
   * @param  SoDeviceRequest  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(SoDeviceRequest $request): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevice criar');

    $val = $request->validated();

    // Todo: ajustar nome da validação
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
      ->toast("$this->titleSingular adicionado com sucesso.", 'success');
  }

  /**
   * Display the specified resource.
   *
   * @return \Inertia\Response
   */
  public function show($id): \Inertia\Response
  {
    $this->authorize('soDevice ver');

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
   * @return \Momentum\Modal\Modal
   */
  public function edit($id): \Momentum\Modal\Modal
  {
    $this->authorize('soDevice editar');

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
   *
   * @param  SoDeviceRequest  $request
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(SoDeviceRequest $request, $id): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevice editar');

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
   *
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy($id): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('soDevice excluir');

    $this->service->deleteById($id);

    return redirect()->route($this->pageIndex)
      ->toast("$this->titleSingular excluído.", 'success');
  }
}
