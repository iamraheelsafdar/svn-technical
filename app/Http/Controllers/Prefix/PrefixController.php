<?php

namespace App\Http\Controllers\Prefix;

use App\Http\Requests\Prefix\CheckPrefixIdRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Prefix\AddPrefixRequest;
use App\Http\Resources\OrderRequestCollection;
use App\Http\Resources\Prefix\PrefixResource;
use App\Filters\Prefix\PrefixAssignFilter;
use App\Filters\Prefix\PrefixStatusFilter;
use App\Filters\Prefix\PrefixNameFilter;
use App\Filters\Prefix\PrefixDateFilter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;
use App\Models\Prefix;

class PrefixController extends Controller
{

    /**
     * @return Application|Factory|View|
     */
    public function addPrefixView(): Factory|View|Application
    {
        $assignPrefixes = ['Course Management', 'Svn Enrollment'];
        return view('prefix.add-prefix', ['assignPrefixes' => $assignPrefixes]);
    }

    /**
     * @param AddPrefixRequest $request
     * @return RedirectResponse
     */
    public function addPrefix(AddPrefixRequest $request): RedirectResponse
    {
        Prefix::create([
            'prefix' => $request->prefix_name,
            'prefix_assign_to' => $request->assign_prefix,
        ]);
        session()->flash('success', 'Prefix added successfully.');
        return redirect()->route('prefixesPage');
    }

    /**
     * @param Request $request
     * @return Factory|View|Application
     */
    public function prefixes(Request $request): Factory|View|Application
    {
        $prefixes = app(Pipeline::class)
            ->send(Prefix::query())
            ->through([
                PrefixDateFilter::class,
                PrefixNameFilter::class,
                PrefixAssignFilter::class,
                PrefixStatusFilter::class,
            ])
            ->thenReturn()
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 5);


        $orderRequests = new OrderRequestCollection($prefixes);
        $orderRequests->setResourceClass(PrefixResource::class);
        $filteredPrefixes = $orderRequests->toArray($request);
        return view('prefix.prefixes', ['prefixes' => $filteredPrefixes, 'assignedPrefixes' => Prefix::pluck('prefix_assign_to')->unique()->values()->toArray()]);
    }

    /**
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function updatePrefixView($id): Factory|View|Application|RedirectResponse
    {
        $prefix = Prefix::find($id);
        if (!$prefix) {
            return redirect()->back()->with('validation_errors', ['Prefix not found.']);
        }
        $assignPrefixes = ['Course Management', 'Svn Enrollment'];
        return view('prefix.update-prefix', ['prefix' => $prefix, 'assignPrefixes' => $assignPrefixes]);
    }

    /**
     * @param CheckPrefixIdRequest $request
     * @return JsonResponse
     */
    public function updatePrefixStatus(CheckPrefixIdRequest $request): JsonResponse
    {
        $prefix = Prefix::find($request->id);
        $prefix->update(['status' => (bool)$request->status]);
        return response()->json([
            'header_code' => 200,
            'message' => 'Prefix status updated successfully.',
        ]);
    }

    /**
     * @param CheckPrefixIdRequest $request
     * @return RedirectResponse
     */
    public function updatePrefix(CheckPrefixIdRequest $request): RedirectResponse
    {
        $prefix = Prefix::find($request->id);
        $prefix->update([
            'prefix' => $request->prefix_name,
            'prefix_assign_to' => $request->assign_prefix,
        ]);
        session()->flash('success', 'Prefix updated successfully.');
        return redirect()->route('prefixesPage');
    }
}
