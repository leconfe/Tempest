<x-tempest::layouts.main>
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="mb-8">
            <x-tempest::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()"
                class="text-xs sm:text-sm bg-white rounded-lg shadow-sm px-2 sm:px-4 py-2 sm:py-3 font-medium overflow-x-auto" />
        </div>
        @if ($currentScheduledConference?->committees->isNotEmpty())
            <x-scheduledConference::committees :committeeRoles="$committeeRoles"/>
        @endif
    </div>
</x-tempest::layouts.main>
