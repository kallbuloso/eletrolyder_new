<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
   * @return \Inertia\Response
   */
  public function index(Request $request): \Inertia\Response
  {
    $this->authorize('user list');

    $query = User::query()->when($request->get('search'), function ($query, $search) {
      $search = strtolower(trim($search));
      return $query->whereRaw('LOWER(name) LIKE ?', ["%$search%"]);
    })->when($request->get('sort'), function ($query, $sortBy) {
      return $query->orderBy($sortBy['key'], $sortBy['order']);
    });

    // $users = $this->service->paginate(request('per_page', 20), request('keywords', ''),  '*', 'page', null);
    return $this->renderPage('Settings/User/Index', [
      'title' => $this->pageTitle,
      'breadcrumbs' => [
        ['title' => 'Dashboard', 'href' => route('dashboard')],
        ['title' => $this->pageTitle, 'disabled' => true],
      ],
      'data' => $query->paginate($request->get('limit', 10)),
      // 'data' => $users,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Inertia\Response
   */
  public function create(): \Inertia\Response
  {
    $this->authorize('user create');

    return $this->renderPage('Settings/User/Form', [
      'title' => "Adicionar $this->titleSingular",
      'breadcrumbs' => [
        ['title' => 'Dashboard', 'href' => route('dashboard')],
        ['title' => $this->pageTitle, 'href' => route('settings.user.index')],
        ['title' => 'Adicionar', 'disabled' => true],
      ],
      'roles' => Role::all(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  UserRequest  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(UserRequest $request): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('user create');

    $user = $this->service->create($request->validated());
    $user->syncRoles($request->roles);

    return redirect()->route('settings.user.index')
      ->toast("$this->titleSingular criado.", 'success');
  }

  /**
   * Display the specified resource.
   *
   * @return \Inertia\Response
   */
  public function show($id): \Inertia\Response
  {
    $this->authorize('user show');

    return $this->renderPage('Settings/User/Show', [
      'title' => 'Detalhes de ' . $this->titleSingular,
      'breadcrumbs' => [
        ['title' => 'Dashboard', 'href' => route('dashboard')],
        ['title' => $this->pageTitle, 'href' => route('settings.user.index')],
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
    $this->authorize('user edit');

    return $this->renderPage('Settings/User/Form', [
      'title' => "Editando $this->titleSingular",
      'breadcrumbs' => [
        ['title' => 'Dashboard', 'href' => route('dashboard')],
        ['title' => $this->pageTitle, 'href' => route('settings.user.index')],
        ['title' => 'Editar', 'disabled' => true],
      ],
      'data' => $this->service->getById($id)->load('roles'),
      'roles' => Role::all(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  UserRequest  $request
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
  {
    $this->authorize('user edit');

    $validate = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($id)],
      'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
      'profile_photo_path' => 'string|nullable',
      'roles.*' => 'nullable|exists:roles,id',
    ]);

    dd($request->roles);

    $user = $this->service->getById($id);

    $user->update([
      'name' => $request->name,
      'email' => $request->email,
      'profile_photo_path' => $request->profile_photo_path,
    ]);

    if ($request->password) {
      $user->update([
        'password' => Hash::make($request->password)
      ]);
    }

    $roles = $request->roles ?? [];
    $user->syncRoles($roles);

    return redirect()->route('settings.user.index')
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
    $this->authorize('user delete');

    $this->service->deleteById($id);

    return redirect()->route('settings.user.index')
      ->toast("$this->titleSingular excluído.", 'success');
  }
}
