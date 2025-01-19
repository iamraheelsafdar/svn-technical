<?php

namespace App\Http\Controllers\Enrollment;

use App\Http\Requests\Enrollment\CheckEnrollmentIdRequest;
use App\Http\Requests\Enrollment\UpdateEnrollmentRequest;
use App\Http\Requests\Enrollment\AddEnrollmentRequest;
use App\Http\Resources\Enrollment\EnrollmentResource;
use App\Filters\Enrollment\EnrollmentCreatedFilter;
use App\Filters\Enrollment\EnrollmentPrefixFilter;
use App\Filters\Enrollment\EnrollmentStatusFilter;
use App\Filters\Enrollment\EnrollmentStreamFilter;
use App\Filters\Enrollment\EnrollmentNameFilter;
use App\Filters\Enrollment\EnrollmentYearFilter;
use App\Http\Resources\OrderRequestCollection;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use App\Models\Enrollment;
use App\Models\SvnStream;
use Illuminate\View\View;
use App\Models\Prefix;

class EnrollmentController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function addEnrollmentView(): Factory|View|Application
    {
        $prefix = Prefix::where([['prefix_assign_to', 'Svn Enrollment'], ['status', 1]])->pluck('id', 'prefix')->toArray();
        $stream = SvnStream::where('status', 1)->pluck('id', 'name')->toArray();
        $enrollmentDetails = ['prefix' => $prefix, 'stream' => $stream];
        return view('enrollment.add-enrollment', ['enrollmentDetails' => $enrollmentDetails]);
    }

    /**
     * @param AddEnrollmentRequest $request
     * @return RedirectResponse
     */
    public function addEnrollment(AddEnrollmentRequest $request): RedirectResponse
    {
        Enrollment::create([
            'year_start' => $request->session_year,
            'name' => $request->enrollment_name,
            'prefix_id' => $request->prefix,
            'stream_id' => $request->stream,
            'status' => 1,
        ]);

        session()->flash('success', 'Enrollment added successfully.');
        return redirect()->route('enrollmentsPage');
    }

    /**
     * @param Request $request
     * @return Factory|View|Application
     */
    public function enrollments(Request $request): Factory|View|Application
    {
        $enrollments = app(Pipeline::class)
            ->send(Enrollment::query())
            ->through([
                EnrollmentCreatedFilter::class,
                EnrollmentPrefixFilter::class,
                EnrollmentStreamFilter::class,
                EnrollmentStatusFilter::class,
                EnrollmentNameFilter::class,
                EnrollmentYearFilter::class,
            ])
            ->thenReturn()
            ->with('prefix', 'stream')
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 5);

        $orderRequests = new OrderRequestCollection($enrollments);
        $orderRequests->setResourceClass(EnrollmentResource::class);
        $filteredEnrollments = $orderRequests->toArray($request);
        return view('enrollment.enrollments', ['enrollments' => $filteredEnrollments]);
    }

    /**
     * @param CheckEnrollmentIdRequest $request
     * @return JsonResponse
     */
    public function updateEnrollmentStatus(CheckEnrollmentIdRequest $request): JsonResponse
    {
        $prefix = Enrollment::find($request->id);
        $prefix->update(['status' => (bool)$request->status]);
        return response()->json([
            'header_code' => 200,
            'message' => 'Enrollment status updated successfully.',
        ]);
    }

    /**
     * @param $id
     * @return Application|View|Factory|RedirectResponse
     */
    public function updateEnrollmentView($id): Application|View|Factory|RedirectResponse
    {
        $enrollment = Enrollment::find($id);
        if (!$enrollment) {
            return redirect()->back()->with('validation_errors', ['Enrollment not found.']);
        }
        $savedPrefix = $enrollment->prefix->where('id', $enrollment->prefix_id)->first();
        $prefixDropDown = $enrollment->prefix->where('prefix_assign_to', 'Svn Enrollment')->pluck('id', 'prefix')->toArray();
        $savedStream = $enrollment->stream->where('id', $enrollment->stream_id)->first();
        $streamDropDown = $enrollment->stream->pluck('id', 'name')->toArray();
        return view('enrollment.update-enrollment', [
            'enrollment' => $enrollment,
            'savedPrefix' => $savedPrefix,
            'prefixDropDown' => $prefixDropDown,
            'savedStream' => $savedStream,
            'streamDropDown' => $streamDropDown
        ]);
    }

    /**
     * @param UpdateEnrollmentRequest $request
     * @return RedirectResponse
     */
    public function updateEnrollment(UpdateEnrollmentRequest $request): RedirectResponse
    {
        Enrollment::where('id', $request->id)->update([
            'year_start' => $request->session_year,
            'name' => $request->enrollment_name,
            'prefix_id' => $request->prefix,
            'stream_id' => $request->stream,
        ]);

        session()->flash('success', 'Enrollment updated successfully.');
        return redirect()->route('enrollmentsPage');
    }
}
