<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * User Service
     * @var UserService
     */
    private $service;

    /**
     * Page Title
     * @var string
     */
    private $pageTitle = 'Usuários';

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Usuário';

    /**
     * Summary of pageIndex
     * @var string
     */
    private $pageIndex = 'registers.user.index';

    /**
     * Summary of pathView
     * @var string
     */
    private $pathView = 'Registers/User';

    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request): JsonResponse|\Inertia\Response
    {
        $this->authorize('user listar');

        try {
            $query = User::query();
            $fields = User::getSearchable();
            $query = $this->service->applyFilters($query, $request, $fields);
            // Carregar os relacionamentos
            $query->with(['roles']);
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
                'usersCount' => $this->service->count(),
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
        $this->authorize('user criar');

        return $this->renderModal("$this->pathView/Form")
            ->with([
                'title' => "Adicionar $this->titleSingular",
                'roles' => Role::where('tenant_id', session('tenant_id'))->get(),
            ])
            ->baseRoute($this->pageIndex);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('user criar');

        $validated = $request->validated();

        $existingUser = $this->service->where('email', $validated['email'])
            ->where('tenant_id', session('tenant_id'))
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['email' => 'Já existe um usuário com esse email.'])
                ->withInput();
        }

        if (empty($request->roles)) {
            return redirect()->back()
                ->withErrors(['roles' => 'Selecione um tipo de acesso.'])
                ->withInput();
        }

        $user = $this->service->create($validated);
        $user->syncRoles($request->roles);

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
        $this->authorize('user editar');

        $data = $this->service->getById($id)->load('roles');
        // dd($data);

        return $this->renderModal("$this->pathView/Form")
            ->with([
                'title' => "Editando $this->titleSingular",
                'data' => $data,
                'roles' => Role::where('tenant_id', session('tenant_id'))->get(),
            ])
            ->baseRoute($this->pageIndex);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('user editar');

        $validate = $request->validated();

        $existingUser = $this->service->where('email', $validate['email'])
            ->where('tenant_id', $validate['tenant_id'])
            ->where('id', '!=', $id)
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['email' => 'Já existe um usuário com esse email.'])
                ->withInput();
        }

        if (empty($request->roles)) {
            return redirect()->back()
                ->withErrors(['roles' => 'Selecione um tipo de acesso.'])
                ->withInput();
        }

        $user = $this->service->getById($id);

        $user->update([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'profile_photo_path' => $validate['profile_photo_path'],
        ]);

        if ($validate['password']) {
            $user->update([
                'password' => Hash::make($validate['password'])
            ]);
        }

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

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
        $this->authorize('user excluir');

        $this->service->deleteById($id);

        return redirect()->route($this->pageIndex)
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
