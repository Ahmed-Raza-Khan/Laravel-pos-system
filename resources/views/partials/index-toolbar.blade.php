@props(['placeholder' => 'Search...'])
    <form method="GET" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <section class="flex flex-1 flex-wrap items-center gap-3">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}" class="w-full sm:w-72 rounded-2xl py-3 border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @foreach(request()->except(['search', 'page']) as $key => $value)
                @if(is_string($value) || is_numeric($value))
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

            <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Search</button>
            @if(request()->hasAny(['search', 'sort', 'direction']))
                <a href="{{ url()->current() }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600">Clear</a>
            @endif
        </section>

        <section class="flex items-center gap-2 text-sm text-slate-500">
            <label>Per page</label>
            <select name="per_page" onchange="this.form.submit()" class="rounded-xl border-slate-200 text-sm">
                @foreach([10, 25, 50] as $n)
                    <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
        </section>
    </form>
