<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $activities = Activity::query()
            ->with('category')
            ->search($request->query('search'))
            ->filterCategory($request->query('category_id'))
            ->filterStatus($request->query('status'))
            ->sortDate($request->query('sort'))
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('activities.index', compact('activities', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('activities.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreActivityRequest $request,
        ActivityService $service
    ): RedirectResponse {
        $activity = $service->create($request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity): View
    {
        $activity->load('category');

        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity): View
    {
        $categories = Category::all();

        return view('activities.edit', compact('activity', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateActivityRequest $request,
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->update($activity, $request->validated());
        } catch (DomainException $exception) {
            return back()
                ->withErrors(['status' => $exception->getMessage()])
                ->withInput();
        }

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        $service->delete($activity);

        return to_route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Publish a draft activity.
     */
    public function publish(
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->publish($activity);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Kegiatan berhasil dipublikasikan.');
    }

    /**
     * Mark a published activity as completed.
     */
    public function complete(
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->complete($activity);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Kegiatan telah ditandai selesai.');
    }
}
