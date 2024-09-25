<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Functions\Helper;
use App\Http\Requests\WorkRequest;
use App\Models\Work;
use App\Models\Type;
use App\Models\Technology;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $works = Work::orderby('id')->get();
        return view('admin.work.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tecs = Technology::all();
        $types = Type::all();
        return view('admin.work.create', compact('types', 'tecs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Helper::generateSlug($data['title'], Work::class);
        $new_work = new Work();


        $new_work->fill($data);
        $new_work->save();
        // Se esistono tecnologie associate al progetto, collegale al nuovo progetto
        if (array_key_exists('technologies', $data)) {
            // Aggiunge le tecnologie selezionate tramite la relazione many-to-many
            $new_work->technologies()->attach($data['technologies']);
        }
        return redirect()->route('admin.work.show', $new_work->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Work $work)
    {
        $work = Work::find($work->id);

        return view('admin.work.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Work $work)
    {
        /*   $work=Work::find($work); */
        $tecs = Technology::all();
        $types = Type::all();
        return view('admin.work.edit', compact('work', 'types', 'tecs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkRequest $request, Work $work)
    {
        $data = $request->all();

        if ($data['title'] != $work['title']) {
            $data['slug'] = Helper::generateSlug($data['title'], Work::class);
        }
        $work->update($data);
        // Se ci sono tecnologie selezionate, aggiorna i collegamenti tra il progetto e le tecnologie
        if (array_key_exists('technologies', $data)) {
            // Sincronizza le tecnologie selezionate con il progetto (aggiunge o rimuove collegamenti)
            $work->technologies()->sync($data['technologies']);
        } else {
            // Se nessuna tecnologia è stata selezionata, rimuove tutte le tecnologie associate
            $work->technologies()->detach();
        }
        return redirect()->route('admin.work.show', $work)->with('update', 'Il Progetto è stato aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work)
    {
        $work->delete();
        return redirect()->route('admin.work.index')->with('delete', 'il Progetto' . $work['title'] . ' è stato cancellato');
    }
}