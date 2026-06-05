<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div>
        <label class="block mb-2 font-medium">
            Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name',$warehouse->name ?? '') }}"
            class="w-full rounded-lg border-slate-300"
            required>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Code
        </label>

        <input
            type="text"
            name="code"
            value="{{ old('code',$warehouse->code ?? '') }}"
            class="w-full rounded-lg border-slate-300"
            required>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Phone
        </label>

        <input
            type="text"
            name="phone"
            value="{{ old('phone',$warehouse->phone ?? '') }}"
            class="w-full rounded-lg border-slate-300">
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-lg border-slate-300">

            <option value="1"
                {{ old('status',$warehouse->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('status',$warehouse->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>

        </select>
    </div>

    <div class="md:col-span-2">

        <label class="block mb-2 font-medium">
            Address
        </label>

        <textarea
            name="address"
            rows="4"
            class="w-full rounded-lg border-slate-300">{{ old('address',$warehouse->address ?? '') }}</textarea>

    </div>

</div>