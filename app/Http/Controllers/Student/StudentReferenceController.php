<?php

namespace App\Http\Controllers\Student;

use App\Filters\Student\StudentReferenceDateFilter;
use App\Filters\Student\StudentReferenceName;
use App\Filters\Student\StudentReferenceStatusFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\AddStudentReferenceRequest;
use App\Http\Requests\Student\StudentReferenceRequest;
use App\Http\Resources\OrderRequestCollection;
use App\Http\Resources\Student\StudentReferenceResource;
use App\Models\StudentReference;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class StudentReferenceController extends Controller
{
    /**
     * @return View|Application|Factory
     */
    public function studentsReference(Request $request): View|Application|Factory
    {
        $references = app(Pipeline::class)
            ->send(StudentReference::query())
            ->through([
                StudentReferenceStatusFilter::class,
                StudentReferenceDateFilter::class,
                StudentReferenceName::class
            ])
            ->thenReturn()
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 5);

        $orderRequests = new OrderRequestCollection($references);
        $orderRequests->setResourceClass(StudentReferenceResource::class);
        $filteredReferences = $orderRequests->toArray($request);
        return view('student.student-reference', ['references' => $filteredReferences]);
    }

    public function addStudentReferenceView(): View|Application|Factory
    {
        return view('student.add-student-reference');
    }

    /**
     * @param AddStudentReferenceRequest $request
     * @return RedirectResponse
     */
    public function addStudentReference(AddStudentReferenceRequest $request): RedirectResponse
    {
        StudentReference::create([
            'reference' => $request->reference
        ]);
        session()->flash('success', 'Reference added successfully.');
        return redirect()->route('studentsReference');
    }

    public function updateStudentReference(StudentReferenceRequest $request): RedirectResponse
    {
        StudentReference::find($request->id)->update([
            'reference' => $request->reference
        ]);
        session()->flash('success', 'Student updated successfully.');
        return redirect()->route('studentsView');
    }

    public function updateStudentReferenceView(StudentReferenceRequest $request): Factory|View|Application
    {
        $reference = StudentReference::find($request->id)->first();
        return view('student.update-student-reference', ['reference' => $reference]);
    }

    public function updateReferenceStatus(StudentReferenceRequest $request): JsonResponse
    {
        $prefix = StudentReference::find($request->id);
        $prefix->update(['status' => (bool)$request->status]);
        return response()->json([
            'header_code' => 200,
            'message' => 'Reference status updated successfully.',
        ]);
    }
}
