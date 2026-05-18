@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="w-full mx-auto space-y-6">
    <section class="mb-2">
        <h1 class="text-3xl font-bold text-slate-900">Profile Settings</h1>
        <p class="text-slate-500 mt-1">Update your account information and password.</p>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @include('profile.partials.update-profile-information-form')
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @include('profile.partials.update-password-form')
    </section>

    <section class="rounded-3xl border border-red-100 bg-white p-6 shadow-sm">
        @include('profile.partials.delete-user-form')
    </section>
</section>
@endsection
