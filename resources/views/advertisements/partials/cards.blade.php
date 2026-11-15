    {{-- Advertisement Cards --}}
        @if($advertisements->count())

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

                @foreach($advertisements as $ad)

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">

                        {{-- Image --}}
                        <a href="{{ route('advertisement.show', $ad->slug) }}"
                           class="block relative">

                            @if($ad->image)
                                <img
                                    src="{{ asset('uploads/advertisements/'.$ad->image) }}"
                                    alt="{{ $ad->title }}"
                                    class="w-full h-48 object-cover"
                                >
                            @else
                                <div class="w-full h-48 bg-green-50 flex items-center justify-center">
                                    <span class="text-5xl">📢</span>
                                </div>
                            @endif

                            @if($ad->is_featured)
                                <span class="absolute top-3 left-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                    ⭐ বিশেষ বিজ্ঞাপন
                                </span>
                            @endif

                        </a>

                        <div class="p-4 flex flex-col flex-1">

                            {{-- Type Badge --}}
                            <div class="mb-3">
                                <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full
                                    {{ $adTypeColors[$ad->ad_type] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $adTypeLabels[$ad->ad_type] ?? 'বিজ্ঞাপন' }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <a href="{{ route('advertisement.show', $ad->slug) }}">
                                <h3 class="text-base font-bold text-gray-800 hover:text-green-700 leading-6 line-clamp-2 min-h-12">
                                    {{ $ad->title }}
                                </h3>
                            </a>

                            {{-- Description --}}
                            <p class="text-sm text-gray-500 leading-6 mt-2 line-clamp-2 min-h-12">
                                {{ $ad->short_description }}
                            </p>

                            {{-- Location --}}
                            <p class="text-xs text-gray-500 mt-3">
                                📍 {{ $ad->location ?: 'এলাকা উল্লেখ নেই' }}
                            </p>

                            {{-- Price --}}
                            @if($ad->price_label)
                                <p class="text-base font-bold text-green-700 mt-3">
                                    {{ $ad->price_label }}
                                </p>
                            @endif

                            {{-- Details Button --}}
                            <a href="{{ route('advertisement.show', $ad->slug) }}"
                               class="mt-auto pt-4">

                                <span class="flex items-center justify-center gap-2 w-full bg-green-50 hover:bg-green-600 text-green-700 hover:text-white font-semibold text-sm py-3 rounded-xl transition">
                                    বিস্তারিত দেখুন
                                    <span>→</span>
                                </span>

                            </a>

                        </div>

                    </div>

                @endforeach

            </div>
            
        @else

            {{-- Empty State --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-10 sm:p-16 text-center">

                <div class="text-6xl mb-4">🔎</div>

                <h3 class="text-xl font-bold text-gray-800">
                    কোনো বিজ্ঞাপন পাওয়া যায়নি
                </h3>

                <p class="text-gray-500 text-sm mt-2">
                    অন্য কোনো শব্দ দিয়ে সার্চ করুন অথবা ফিল্টার পরিবর্তন করুন।
                </p>

                <a href="{{ route('advertisements.index') }}"
                   class="inline-block mt-5 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl">
                    সকল বিজ্ঞাপন দেখুন
                </a>

            </div>

        @endif
        <div id="adPagination" class="mt-8">
    {{ $advertisements->links() }}
</div>