<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\ProfileSettingRequest;
use App\Http\Requests\Dashboard\SiteSettingRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Application;
use Illuminate\View\Factory;
use App\Models\SiteSettings;
use App\Models\Enrollment;
use Illuminate\View\View;
use App\Models\Students;
use App\Models\Course;
use App\Models\User;

class DashboardController extends Controller
{

    public function dashboardView(): View|Application|Factory
    {
        $centers = User::where('role', 'Center')->get();
        $enrollments = new Enrollment;
        $students = new Students;
        $courses = new Course;
        $details = [
            'total_centers' => $centers->count(),
            'inactive_centers' => $centers->where('status', 0)->count(),
            'active_centers' => $centers->where('status', true)->count(),
            'total_enrollments' => $enrollments->count(),
            'inactive_enrollments' => $enrollments->where('status', 0)->count(),
            'active_enrollments' => $enrollments->where('status', 1)->count(),
            'total_courses' => $courses->count(),
            'inactive_courses' => $courses->where('status', 0)->count(),
            'active_courses' => $courses->where('status', 1)->count(),
            'total_students' => auth()->user()->role == 'Admin' ? $students->count() : $students->where('center_id', auth()->user()->id)->count(),
            'inactive_students' => auth()->user()->role == 'Admin' ? $students->where('status', 0)->count() : $students->where('center_id', auth()->user()->id)->where('status', 0)->count(),
            'active_students' => auth()->user()->role == 'Admin' ? $students->where('status', 1)->count() : $students->where('center_id', auth()->user()->id)->where('status', 1)->count(),
        ];
        return view('dashboard.dashboard', ['details' => $details]);
    }

    /**
     * @return View|Application|Factory
     */
    public function siteSetting(): View|Application|Factory
    {
        $siteSetting = SiteSettings::first();
        return view('dashboard.site-setting', ['siteSetting' => $siteSetting]);
    }

    /**
     * @param SiteSettingRequest $request
     * @return RedirectResponse
     */
    public function updateSetting(SiteSettingRequest $request): RedirectResponse
    {
        $siteSettings = SiteSettings::firstOrCreate(['id' => 1]);
        $siteSettings->update([
            'email' => $request->email,
            'phone' => $request->phone,
            'title' => $request->title,
            'copyright' => $request->copyright,
        ]);
        if ($siteSettings->logo && $request->hasFile('logo')) {
            Storage::disk('public')->delete($siteSettings->logo);
        }
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = Storage::disk('public')->put('site_settings/', $file);
            $siteSettings->update(['logo' => $path]);
        }
        return redirect()->back()->with('success', 'Setting Updated Successfully');
    }

    /**
     * @return View|Application|Factory
     */
    public function profileSetting(): View|Application|Factory
    {
        $profileSetting = User::where('id', auth()->user()->id)->first();
        return view('dashboard.profile-setting', ['profileSetting' => $profileSetting]);
    }

    /**
     * @param ProfileSettingRequest $request
     * @return Factory|View|Application|RedirectResponse
     */
    public function updateProfile(ProfileSettingRequest $request): Factory|View|Application|RedirectResponse
    {
        $profileSetting = User::where('id', auth()->user()->id)->first();
        $profileSetting->update([
            'name' => $request->name ? $request->name : $profileSetting->name,
            'email' => $request->email ? $request->email : $profileSetting->email,
            'phone' => $request->phone ? $request->phone : $profileSetting->phone
        ]);
        if ($profileSetting->profile_image && $request->hasFile('profile_image')) {
            Storage::disk('public')->delete($profileSetting->profile_image);
        }
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $path = Storage::disk('public')->put('profile_settings/', $file);
            $profileSetting->update(['profile_image' => $path]);
        }

        if ($request->filled('new_password')) {
            if (Hash::check($request->old_password, $profileSetting->password)) {
                $profileSetting->update([
                    'password' => Hash::make($request->new_password)
                ]);
            } else {
                return redirect()->back()->with('validation_errors', ['Old password is incorrect']);
            }
        }
        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }
}
