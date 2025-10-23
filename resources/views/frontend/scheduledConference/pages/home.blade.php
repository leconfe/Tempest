<x-tempest::layouts.main>
    <div class="space-y-8">
        <section id="highlight" class="space-y-4">
            <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 gap-4">
                <div class="flex flex-col gap-4 flex-1">
                    @if ($currentScheduledConference->hasMedia('cover'))
                        <div class="cf-cover">
                            <img class="h-full"
                                src="{{ $currentScheduledConference->getFirstMedia('cover')->getAvailableUrl(['thumb', 'thumb-xl']) }}"
                                alt="{{ $currentScheduledConference->title }}" />
                        </div>
                    @endif
                </div>
            </div>
        </section>

        @php 
            $layouts = App\Facades\Plugin::getPlugin('Tempest')->getSetting('layouts');
        @endphp

        @if ($layouts)
            @foreach ($layouts as $layout)
                @switch($layout['type'])
                    @case('layouts')
                        <section @class([
                            Str::snake($layout['data']['name_content']) => true,
                            'prose prose-li: max-w-none w-full',
                        ])>
                            {{ new Illuminate\Support\HtmlString($layout['data']['about']) }}
                        </section>
                    @break
                    @case('committees')
                        @if ($currentScheduledConference?->committees->isNotEmpty())
                            <x-scheduledConference::committees :data="$layout['data']" :committeeRoles="App\Models\CommitteeRole::with(['committees'])->get()"/>
                        @endif
                    @break
                    @case('speakers')
                        <x-scheduledConference::speakers />
                    @break
                    @case('sponsors')
                        @if ($sponsorLevels->isNotEmpty() || $sponsorsWithoutLevel->isNotEmpty())
                            <x-scheduledConference::sponsors :sponsorLevels="$sponsorLevels" :sponsorsWithoutLevel="$sponsorsWithoutLevel" :data="$layout['data']" />
                        @endif
                    @break
                    @case('partners')
                        @if ($partners->isNotEmpty())
                            <x-scheduledConference::partners :partners="$partners" />
                        @endif
                    @break
                    @case('latest-news')
                        @if ($currentScheduledConference)
                            <x-scheduledConference::latest-news />
                        @endif
                    @break
                @endswitch
            @endforeach
        @endif
</x-tempest::layouts.main>