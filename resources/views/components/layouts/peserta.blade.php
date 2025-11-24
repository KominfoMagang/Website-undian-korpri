<x-layouts.app :title="$title ?? 'Peserta'">
    <div class="min-h-screen bg-gray-50 p-4 flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>

</x-layouts.app>
