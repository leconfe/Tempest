@props([
    'title' => null,
])
<x-tempest::layouts.base :title="$title">
    <div class="flex h-full min-h-screen bg-white flex-col">
        @hook('Frontend::Views::Header')

        {{-- Load Header Layout --}}
        <x-tempest::layouts.header/>

        <main class="bg-white w-full">
            {{-- Load Main Layout --}}
            {{ $slot }}
        </main>

        {{-- Load Footer Layout --}}
        <x-tempest::layouts.footer />

        @hook('Frontend::Views::Footer')
    </div>
</x-tempest::layouts.base>
