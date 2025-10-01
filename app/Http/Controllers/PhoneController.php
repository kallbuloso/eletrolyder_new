<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Services\PhoneService;
use App\Http\Controllers\Controller;

/**
 * Class PhoneController
 * @package App\Http\Controllers
 */
class PhoneController extends Controller
{
    /**
     * Phone Service
     * @var PhoneService
     */
    private $service;

    /**
     * Title Singular
     * @var string
     */
    private $titleSingular = 'Telefone';

    /**
     * PhoneController constructor.
     * @param PhoneService $service
     */
    public function __construct(PhoneService $service)
    {
        $this->service = $service;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PhoneRequest  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PhoneRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('phone editar');

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
        $this->authorize('phone excluir');

        $this->service->deleteById($id);

        return redirect()->back()
            ->toast("$this->titleSingular excluído.", 'success');
    }
}
