<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $players = Player::with('user:id,name')->latest()->get();

        return Inertia::render('Players/Index', [
            'players' => $players
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->players()->create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player): RedirectResponse
    {
        Gate::authorize('update', $player);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $player->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player): RedirectResponse
    {
        Gate::authorize('delete', $player);

        $player->delete();

        return redirect()->back();
    }

    /**
     * Randomize and group the players.
     */
    public function randomize(): Response 
    {
        $players = Player::with('user:id,name')->latest()->get();

        if (!count($players)) {
            return Inertia::render('Players/Index', [
                'players' => $players
            ]);
        }

        $groups = array();
        $oldArr = $players->shuffle()->all();

        if (count($oldArr) < 6) {
            return Inertia::render('Players/Index', [
                'players' => $players
            ]);
        } 
        
        if (count($oldArr) % 4 === 1) {
            for ($i=0; $i<3; $i++) {
                array_unshift($groups, collect([
                    array_pop($oldArr),
                    array_pop($oldArr),
                    array_pop($oldArr),
                ]));
            }
        }

        if (count($oldArr) % 4 === 2) {
            for ($i=0; $i<2; $i++) {
                array_unshift($groups, collect([
                    array_pop($oldArr),
                    array_pop($oldArr),
                    array_pop($oldArr),
                ]));
            }
        }

        if (count($oldArr) % 4 === 3) {
            array_unshift($groups, collect([
                array_pop($oldArr),
                array_pop($oldArr),
                array_pop($oldArr),
            ]));
        }

        if (count($oldArr) % 4 === 0) {
            while (count($oldArr)) {
                array_unshift($groups, collect([
                    array_pop($oldArr),
                    array_pop($oldArr),
                    array_pop($oldArr),
                    array_pop($oldArr),
                ]));
            }
        }

        return Inertia::render('Players/Randomize', [
            'groups' => $groups
        ]);
    }

    public function clear(): RedirectResponse
    {
        Player::with('user:id,name')->truncate();

        return redirect(route('players.index'));
    }
}
