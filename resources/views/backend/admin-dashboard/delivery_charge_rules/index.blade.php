@extends('apps.dashboard_master')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Delivery Charge Rules
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                পণ্যের পরিমাণ অনুযায়ী ডেলিভারি চার্জ নির্ধারণ করুন।
            </p>
        </div>

        <button
            type="button"
            onclick="openAddModal()"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow"
        >
            + নতুন Rule যোগ করুন
        </button>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error --}}
    @if($errors->any())

        <div class="mb-5 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">

            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- Rules --}}
    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-5 py-4 text-left">
                            #
                        </th>

                        <th class="px-5 py-4 text-left">
                            Unit
                        </th>

                        <th class="px-5 py-4 text-left">
                            Quantity Range
                        </th>

                        <th class="px-5 py-4 text-left">
                            Delivery Charge
                        </th>

                        <th class="px-5 py-4 text-left">
                            Status
                        </th>

                        <th class="px-5 py-4 text-right">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($rules as $rule)

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-5 py-4">

                                @if($rule->unit_type === 'kg_liter')

                                    <span class="font-semibold text-blue-700">
                                        কেজি / লিটার
                                    </span>

                                @elseif($rule->unit_type === 'piece')

                                    <span class="font-semibold text-purple-700">
                                        পিস
                                    </span>

                                @elseif($rule->unit_type === 'packet')

                                    <span class="font-semibold text-orange-700">
                                        প্যাকেট
                                    </span>

                                @elseif($rule->unit_type === 'dozen')

                                    <span class="font-semibold text-indigo-700">
                                        ডজন
                                    </span>

                                @else

                                    <span class="font-semibold text-gray-700">
                                        {{ $rule->unit_type }}
                                    </span>

                                @endif

                            </td>


                            <td class="px-5 py-4">

                                {{ rtrim(rtrim(number_format($rule->min_quantity, 2), '0'), '.') }}

                                -

                                {{ rtrim(rtrim(number_format($rule->max_quantity, 2), '0'), '.') }}

                            </td>


                            <td class="px-5 py-4 font-bold text-green-700">

                                ৳{{ number_format($rule->charge, 2) }}

                            </td>


                            <td class="px-5 py-4">

                                @if($rule->status)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Active
                                    </span>

                                @else

                                    <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td class="px-5 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        onclick='openEditModal(@json($rule))'
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold"
                                    >
                                        Edit
                                    </button>


                                    {{-- Status --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.delivery_charge_rules.toggle', $rule) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold"
                                        >
                                            {{ $rule->status ? 'Disable' : 'Enable' }}
                                        </button>

                                    </form>


                                    {{-- Delete --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.delivery_charge_rules.destroy', $rule) }}"
                                        onsubmit="return confirm('এই rule টি মুছে ফেলবেন?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-5 py-10 text-center text-gray-500"
                            >
                                এখনো কোনো Delivery Charge Rule যোগ করা হয়নি।
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- ADD / EDIT MODAL --}}
{{-- ========================================================= --}}

<div
    id="deliveryRuleModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4"
>

    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b">

            <h3
                id="modalTitle"
                class="text-xl font-bold text-gray-800"
            >
                নতুন Delivery Charge Rule
            </h3>

            <button
                type="button"
                onclick="closeModal()"
                class="text-gray-500 hover:text-red-500 text-2xl"
            >
                &times;
            </button>

        </div>


        {{-- Form --}}
        <form
            id="deliveryRuleForm"
            method="POST"
            action="{{ route('admin.delivery_charge_rules.store') }}"
            class="p-6"
        >

            @csrf

            <div id="methodField"></div>


            {{-- Unit --}}
            <div class="mb-4">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Unit
                </label>

                <select
                    name="unit_type"
                    id="unitType"
                    required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500"
                >

                    <option value="kg_liter">
                        কেজি / লিটার
                    </option>

                    <option value="piece">
                        পিস
                    </option>

                    <option value="packet">
                        প্যাকেট
                    </option>

                    <option value="dozen">
                        ডজন
                    </option>

                </select>

            </div>


            {{-- Quantity --}}
            <div class="grid grid-cols-2 gap-4 mb-4">

                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Minimum Quantity
                    </label>

                    <input
                        type="number"
                        name="min_quantity"
                        id="minQuantity"
                        min="0"
                        step="0.01"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5"
                        placeholder="যেমন 0"
                    >

                </div>


                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Maximum Quantity
                    </label>

                    <input
                        type="number"
                        name="max_quantity"
                        id="maxQuantity"
                        min="0"
                        step="0.01"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5"
                        placeholder="যেমন 5"
                    >

                </div>

            </div>


            {{-- Charge --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Delivery Charge
                </label>

                <div class="relative">

                    <span class="absolute left-3 top-2.5 text-gray-500">
                        ৳
                    </span>

                    <input
                        type="number"
                        name="charge"
                        id="charge"
                        min="0"
                        step="0.01"
                        required
                        class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-2.5"
                        placeholder="যেমন 30"
                    >

                </div>

            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeModal()"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold"
                >
                    Save
                </button>

            </div>

        </form>

    </div>

</div>



<script>

function openAddModal()
{
    const modal = document.getElementById('deliveryRuleModal');

    const form = document.getElementById('deliveryRuleForm');

    document.getElementById('modalTitle').innerText =
        'নতুন Delivery Charge Rule';

    form.action =
        "{{ route('admin.delivery_charge_rules.store') }}";

    document.getElementById('methodField').innerHTML = '';

    document.getElementById('unitType').value = 'kg_liter';

    document.getElementById('minQuantity').value = '';

    document.getElementById('maxQuantity').value = '';

    document.getElementById('charge').value = '';

    modal.classList.remove('hidden');

    modal.classList.add('flex');
}


function openEditModal(rule)
{
    const modal = document.getElementById('deliveryRuleModal');

    const form = document.getElementById('deliveryRuleForm');

    document.getElementById('modalTitle').innerText =
        'Delivery Charge Rule Edit';

    form.action =
        "{{ url('/admin/delivery-charge-rules') }}/" + rule.id;

    document.getElementById('methodField').innerHTML =
        '@method("PUT")';

    document.getElementById('unitType').value =
        rule.unit_type;

    document.getElementById('minQuantity').value =
        rule.min_quantity;

    document.getElementById('maxQuantity').value =
        rule.max_quantity;

    document.getElementById('charge').value =
        rule.charge;

    modal.classList.remove('hidden');

    modal.classList.add('flex');
}


function closeModal()
{
    const modal = document.getElementById('deliveryRuleModal');

    modal.classList.add('hidden');

    modal.classList.remove('flex');
}


document.getElementById('deliveryRuleModal')
    .addEventListener('click', function(e) {

        if (e.target === this) {
            closeModal();
        }

    });

</script>

@endsection