<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->get();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:tags|max:255|string',
        ]);
        Tag::create($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Etiqueta creada!',
            'text' => 'La etiqueta se ha creado correctamente.',
        ]);
        return redirect()->route('admin.tags.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);
        $tag->update($request->all());
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Etiqueta actualizada!',
            'text' => 'La etiqueta se ha actualizado correctamente.',
        ]);
        return redirect()->route('admin.tags.edit', $tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Etiqueta eliminada!',
            'text' => 'La etiqueta se ha eliminado correctamente.',
        ]);
        return redirect()->route('admin.tags.index');
    }
}
