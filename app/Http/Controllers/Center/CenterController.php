<?php

namespace App\Http\Controllers\Center;

use App\Http\Requests\Auth\CenterUpdateOrRegisterRequest;
use App\Filters\Center\RegistrationPrefixFilter;
use App\Filters\Center\RegistrantionDateFilter;
use App\Http\Resources\OrderRequestCollection;
use App\Http\Requests\Auth\UpdateCenterStatus;
use App\Http\Resources\Center\CenterResource;
use App\Filters\Center\CenterAddressFilter;
use App\Filters\Center\CenterStatusFilter;
use App\Filters\Center\CenterEmailFilter;
use App\Filters\Center\CenterPhoneFilter;
use App\Filters\Center\CenterStateFilter;
use App\Filters\Center\CenterNameFilter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Jobs\Mail\InvitationMailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\Center;
use App\Models\User;

class CenterController extends Controller
{
    /**
     * @return View|Factory|Application
     */
    public function addCenterView(): View|Factory|Application
    {
        $centerCount = User::where('role', 'Center')->count();
        return view('center.add-centers', ['counts' => $centerCount]);
    }

    /**
     * @param CenterUpdateOrRegisterRequest $request
     * @return RedirectResponse
     */
    public function addCenter(CenterUpdateOrRegisterRequest $request): RedirectResponse
    {
        $file = $request->file('profile_image');
        $path = Storage::disk('public')->put('centers/', $file);
        $center = Center::count();
        $random = Str::random(64);
        $user = User::create([
            'status' => 0,
            'role' => 'Center',
            'name' => $request->name,
            'profile_image' => $path,
            'email' => $request->email,
            'phone' => $request->phone,
            'remember_token' => $random,
            'password' => Hash::make($random),
        ]);
        Center::create([
            'user_id' => $user->id,
            'state' => $request->state,
            'address' => $request->address,
            'owner_name' => $request->owner_name,
            'registration_prefix' => $center == 0 ? 'IGNITM/CL/0' . '129' : 'IGNITM/CL/0' . (129 + $center)
        ]);
        InvitationMailJob::dispatch($user);
        session()->flash('success', 'Center registered successfully.');
        return redirect()->route('centersPage');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function centers(Request $request): Application|Factory|View
    {
        $centers = app(Pipeline::class)
            ->send(Center::query())
            ->through([
                RegistrationPrefixFilter::class,
                RegistrantionDateFilter::class,
                CenterAddressFilter::class,
                CenterStatusFilter::class,
                CenterPhoneFilter::class,
                CenterEmailFilter::class,
                CenterNameFilter::class,
                CenterStateFilter::class,
            ])
            ->thenReturn()
            ->with('user')
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 5);


        $orderRequests = new OrderRequestCollection($centers);
        $orderRequests->setResourceClass(CenterResource::class);
        $filteredCenters = $orderRequests->toArray($request);
        return view('center.centers', ['centers' => $filteredCenters]);
    }

    /**
     * @param UpdateCenterStatus $request
     * @return JsonResponse
     */
    public function updateCenterStatus(UpdateCenterStatus $request): JsonResponse
    {
        $center = Center::find($request->id);
        if ($center->user->remember_token != null) {
            return response()->json([
                'header_code' => 400,
                'errors' => ["You can't update ceneter status until his account verified."],
            ],400);
        }
        $center->user->update(['status' => (bool)$request->status]);
        return response()->json([
            'header_code' => 200,
            'message' => 'Center status updated successfully.',
        ]);
    }

    /**
     * @param $centerId
     * @return Application|View|Factory|RedirectResponse
     */
    public function updateCenterView($centerId): Application|View|Factory|RedirectResponse
    {
        $center = Center::find($centerId);
        if (!$center) {
            return redirect()->back()->with('validation_errors', ['Center not found.']);
        }
        return view('center.update-centers', ['center' => $center]);
    }

    /**
     * @param CenterUpdateOrRegisterRequest $request
     * @return Application|View|Factory|RedirectResponse
     */
    public function updateCenter(CenterUpdateOrRegisterRequest $request): Application|View|Factory|RedirectResponse
    {
        $center = Center::find($request->id);
        if ($request->email != $center->user->email) {
            $center->user->update(['email' => $request->email]);
        }

        $center->update([
            'owner_name' => $request->owner_name,
            'address' => $request->address,
            'state' => $request->state,
        ]);
        $center->user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        if ($center->user->profile_image && $request->hasFile('profile_image')) {
            Storage::disk('public')->delete($center->user->profile_image);
        }
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $path = Storage::disk('public')->put('centers/', $file);
            $center->user->update(['profile_image' => $path]);
        }
        session()->flash('success', 'Center updated successfully.');
        return redirect()->route('centersPage');
    }

    public function deleteCenter(Request $request): RedirectResponse
    {
        $chechPassword = Hash::check($request->password, auth()->user()->password);
        if (!$chechPassword) {
            return redirect()->back()->with('validation_errors', ['Password Mismatch.']);
        }
        Center::find($request->center_id)->user->delete();
        return redirect()->back()->with('success', 'Center Deleted Successfully');
    }
}
