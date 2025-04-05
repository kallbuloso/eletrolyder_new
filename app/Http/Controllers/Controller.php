<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;

    /**
     * Render a page component.
     *
     * @param string $component
     * @param array|null $props
     * @return \Inertia\Response
     */
    public function renderPage(string $component, array $props = []): \Inertia\Response
    {
        return Inertia::render($component, $props);
    }

    /**
     * Render a modal component.
     *
     * @param string $component
     * @param array|null $props
     * @param string|array $baseRoute
     * @return \Momentum\Modal\Modal
     */
    public function renderModal(string $component): \Momentum\Modal\Modal
    {
        return Inertia::modal($component);
    }
}
