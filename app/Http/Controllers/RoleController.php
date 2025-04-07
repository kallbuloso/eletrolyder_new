<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Permission;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * Role Service
     * @var RoleService
     */
    private $service;

    /**
     * Page Title
     * @var string
     */
    private $pageTitle = 'Controle de Acessos';

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Controle de Acesso';

    /**
     * Summary of pageIndex
     * @var string
     */
    private $pageIndex = 'settings.roles.index';

    private $allPermissions;
    /**
     * RoleController constructor.
     * @param RoleService $service
     */
    public function __construct(RoleService $service)
    {
        $this->service = $service;
        $this->allPermissions = Permission::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $this->authorize('role listar');

        $data = $this->service->all();

        return $this->renderPage('Settings/Role/Index', [
            'title' => $this->pageTitle,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'href' => route('dashboard')],
                ['title' => $this->pageTitle, 'disabled' => true],
            ],
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Momentum\Modal\Modal
     */
    public function create(): \Momentum\Modal\Modal
    {
        $this->authorize('role criar');

        return $this->renderModal('Settings/Role/Create')
            ->with([
                'title' => "Adicionar $this->titleSingular",
                'permissions' => $this->allPermissions,
            ])
            ->baseRoute($this->pageIndex);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('role criar');

        $val = $request->validated();

        $existingRole = Role::where('name', $val['name'])
            ->where('tenant_id', $val['tenant_id'])
            ->first();

        if ($existingRole) {
            return redirect()->back()
                ->withErrors(['name' => 'O nome do acesso já existe para esta empresa.'])
                ->withInput();
        }

        $role = $this->service->create($val);
        $role->syncPermissions($request->permissions);


        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular criado.", 'success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Momentum\Modal\Modal
     */
    public function edit($id): \Momentum\Modal\Modal
    {
        $this->authorize('role editar');

        return $this->renderModal('Settings/Role/Edit')
            ->with([
                'title' => "Editando $this->titleSingular",
                'data' => $this->service->getById($id)->load('permissions'),
                'permissions' => $this->allPermissions,
            ])
            ->baseRoute($this->pageIndex);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleUpdateRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('role editar');

        $val = $request->validated();

        $role = $this->service->getById($id);
        $role->name = $val['name'];
        $role->description = $val['description'];
        $role->guard_name = $val['guard_name'];
        $role->save();
        $role->syncPermissions($val['permissions']);

        return redirect()->route($this->pageIndex)
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
        $this->authorize('role excluir');

        $this->service->deleteById($id);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
