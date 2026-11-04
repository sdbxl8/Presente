<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
{
    $profileUser = $request->user()->load('studentGroups.subjects');

    return view('layouts.profile', compact('profileUser'));
}

public function update(Request $request)
{
    $user = $request->user();

    $rules = [
        'name' => ['sometimes', 'required', 'string', 'max:25'],
        'surname' => ['sometimes', 'required', 'string', 'max:40'],
        'email' => [
            'sometimes',
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($user->id),
        ],
    ];

    if ($user->role === 'teacher') {
        $rules['subject_name'] = ['sometimes', 'required', 'string', 'max:100'];
    }

    $data = $request->validate($rules);

    DB::transaction(function () use ($user, $data) {
        $hasSubject = array_key_exists('subject_name', $data);
        $subjectName = $data['subject_name'] ?? null;

        unset($data['subject_name']);

        $user->fill($data);

        if ($hasSubject && $user->role === 'teacher') {
            $user->subject_name = $subjectName;
        }

        $user->save();

        if ($hasSubject && $user->role === 'teacher') {
            $user->groups()
                ->with('subjects')
                ->get()
                ->each(function ($group) use ($subjectName) {
                    $group->subjects()->update(['name' => $subjectName]);
                });
        }
    });

    return back()->with('success', 'Perfil actualizado.');
}

public function updatePhoto(Request $request)
{
    $data = $request->validate([
        'photo' => ['required', 'image', 'max:5120'],
    ]);

    $user = $request->user();
    $newPath = $data['photo']->store('profile-photos', 'public');

    if ($user->photo) {
        Storage::disk('public')->delete($user->photo);
    }

    $user->update([
        'photo' => $newPath,
    ]);

    return back()->with('success', 'Foto actualizada correctamente.');
}
}
