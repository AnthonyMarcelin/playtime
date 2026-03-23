<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('games/Index', [
            'games' => Game::with('gameSessions')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('games/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['source'] = 'manual';

        Game::create($validated);

        return to_route('games.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game): Response
    {
        $game->load('gameSessions');

        return Inertia::render('games/Show', [
            'game' => $game,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game): Response
    {
        return Inertia::render('games/Edit', [
            'game' => $game,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        $game->update($request->validated());

        return to_route('games.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        return to_route('games.index');
    }
}
