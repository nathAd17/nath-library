@foreach ($stats as $stat)
    <div
        class="shadow-lg shadow-lighthover bg-gradient-to-r from-{{ $stat['color'] }}-50 from-40% to-{{ $stat['color'] }}-200 to-100% p-6 rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-600 text-sm font-medium">{{ $stat['label'] }}</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $stat['value'] }}</p>
            </div>
            <div class="w-12 h-12 bg-{{ $stat['color'] }}-500 rounded-lg flex items-center justify-center">
                <i class="{{ $stat['icon'] }} text-white text-xl"></i>
            </div>
        </div>
    </div>

@endforeach
