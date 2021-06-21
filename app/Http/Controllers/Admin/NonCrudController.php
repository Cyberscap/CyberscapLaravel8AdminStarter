<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyNonCrudRequest;
use App\Http\Requests\StoreNonCrudRequest;
use App\Http\Requests\UpdateNonCrudRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NonCrudController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('non_crud_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.nonCruds.index');
    }

    public function create()
    {
        abort_if(Gate::denies('non_crud_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.nonCruds.create');
    }

    public function store(StoreNonCrudRequest $request)
    {
        $nonCrud = NonCrud::create($request->all());

        return redirect()->route('admin.non-cruds.index');
    }

    public function edit(NonCrud $nonCrud)
    {
        abort_if(Gate::denies('non_crud_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.nonCruds.edit', compact('nonCrud'));
    }

    public function update(UpdateNonCrudRequest $request, NonCrud $nonCrud)
    {
        $nonCrud->update($request->all());

        return redirect()->route('admin.non-cruds.index');
    }

    public function show(NonCrud $nonCrud)
    {
        abort_if(Gate::denies('non_crud_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.nonCruds.show', compact('nonCrud'));
    }

    public function destroy(NonCrud $nonCrud)
    {
        abort_if(Gate::denies('non_crud_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $nonCrud->delete();

        return back();
    }

    public function massDestroy(MassDestroyNonCrudRequest $request)
    {
        NonCrud::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
