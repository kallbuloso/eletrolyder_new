<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Services\AddressService;
use App\Http\Controllers\Controller;

/**
 * Class AddressController
 * @package App\Http\Controllers
 */
class AddressController extends Controller
{
    /**
     * Address Service
     * @var AddressService
     */
    private $service;

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Endereço';

    /**
     * AddressController constructor.
     * @param AddressService $service
     */
    public function __construct(AddressService $service)
    {
        $this->service = $service;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AddressRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AddressRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('address editar');

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
        $this->authorize('address excluir');

        $this->service->deleteById($id);

        return redirect()->back()
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
