<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Services\AddressService;

/**
 * Class AddressController
 */
class AddressController extends Controller
{
    /**
     * Address Service
     *
     * @var AddressService
     */
    private $service;

    /**
     * Title Singular
     *
     * @var string
     */
    private $titleSingular = 'Endereço';

    /**
     * AddressController constructor.
     */
    public function __construct(AddressService $service)
    {
        $this->service = $service;
    }

    /**
     * Update the specified resource in storage.
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
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('address excluir');

        $this->service->deleteById($id);

        return redirect()->back()
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
