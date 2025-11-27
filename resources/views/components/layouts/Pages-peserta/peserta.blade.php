<x-layouts.app :title="$title ?? 'Peserta'">
    <div class="min-h-screen bg-gray-50  flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layouts.app>
