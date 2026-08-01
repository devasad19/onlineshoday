        @if(session('success'))
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
        @endif



