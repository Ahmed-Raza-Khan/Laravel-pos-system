@if(session('success'))
    <section class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm font-medium">{{ session('success') }}</section>
@endif
@if(session('error'))
    <section class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm font-medium">{{ session('error') }}</section>
@endif
@if($errors->any())
    <section class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </section>
@endif
