<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Activity;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function store(
        StoreRegistrationRequest $request,
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->registerParticipant($activity, $request->validated());
        } catch (DomainException $e) {
            return back()
                ->withErrors(['registration' => $e->getMessage()])
                ->withInput();
        }

        return back()->with('success', 'Pendaftaran berhasil! Kuota peserta telah diperbarui.');
    }
}
