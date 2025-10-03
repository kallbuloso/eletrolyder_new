<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

abstract class Controller
{
    use AuthorizesRequests;

    /**
     * Render a page component.
     *
     * @param  array|null  $props
     */
    public function renderPage(string $component, array $props = []): \Inertia\Response
    {
        return Inertia::render($component, $props);
    }

    /**
     * Render a modal component.
     *
     * @param  array|null  $props
     * @param  string|array  $baseRoute
     */
    public function renderModal(string $component): \Momentum\Modal\Modal
    {
        return Inertia::modal($component);
    }
}
