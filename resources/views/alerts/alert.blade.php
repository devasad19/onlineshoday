        <!-- @if(session('success'))
            <div id="alert-message" 
                class="fixed top-5 right-5 z-50 w-auto max-w-sm bg-green-100 text-green-800 border border-green-300 rounded-lg shadow-lg p-4 transition-all transform duration-500 opacity-0 translate-y-[-20px]">
                {{ session('success') }}
            </div>
        @endif
            
        @if(session('error'))
            <div id="alert-message" class="fixed top-5 right-5 z-50 w-auto max-w-sm bg-red-100 text-red-800 border border-red-300 rounded-lg shadow-lg p-4 transition-all transform duration-500 opacity-0 translate-y-[-20px]">
            {{ session('error') }}
        </div>
        @endif
             
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->



{{-- Toast Notification --}}
@if(session('success') || session('error') || $errors->any())

    @php
        $toastType = session('success') ? 'success' : 'error';

        $toastMessage = session('success')
            ?? session('error')
            ?? $errors->first();
    @endphp

    <div
        id="toast-notification"
        class="fixed top-5 right-5 z-[9999] w-[calc(100%-30px)] max-w-sm
               opacity-0 translate-x-full pointer-events-none
               transition-all duration-500 ease-out"
    >

        <div
            class="
                flex items-start gap-3
                rounded-xl shadow-2xl
                border
                px-4 py-4
                backdrop-blur-sm
                {{ $toastType === 'success'
                    ? 'bg-green-50 border-green-300 text-green-800'
                    : 'bg-red-50 border-red-300 text-red-800'
                }}
            "
        >

            {{-- Icon --}}
            <div
                class="
                    flex-shrink-0
                    w-9 h-9
                    rounded-full
                    flex items-center justify-center
                    text-lg font-bold
                    {{ $toastType === 'success'
                        ? 'bg-green-100 text-green-600'
                        : 'bg-red-100 text-red-600'
                    }}
                "
            >
                @if($toastType === 'success')
                    ✓
                @else
                    !
                @endif
            </div>


            {{-- Message --}}
            <div class="flex-1 pt-1 text-sm font-medium leading-5">
                {{ $toastMessage }}
            </div>


            {{-- Close --}}
            <button
                type="button"
                onclick="closeToast()"
                class="flex-shrink-0 text-gray-400 hover:text-gray-700 text-xl leading-none"
            >
                ×
            </button>

        </div>


        {{-- Progress bar --}}
        <div
            class="
                h-1 overflow-hidden rounded-b-xl
                {{ $toastType === 'success'
                    ? 'bg-green-200'
                    : 'bg-red-200'
                }}
            "
        >
            <div
                id="toast-progress"
                class="
                    h-full w-full origin-left
                    {{ $toastType === 'success'
                        ? 'bg-green-500'
                        : 'bg-red-500'
                    }}
                "
            ></div>
        </div>

    </div>


@endif