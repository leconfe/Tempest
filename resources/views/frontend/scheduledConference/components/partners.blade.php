@props(['partners'])

@if($partners->isNotEmpty())
	<section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-white">
		<div class="px-4 mx-auto container">
			<div class="max-w-7xl mx-auto">
				<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center mb-6 sm:mb-8 md:mb-10 relative inline-block w-full text-gray-900">
					Partners
					<span class="garis absolute left-1/2 -bottom-3 sm:-bottom-4 transform -translate-x-1/2 w-16 sm:w-20 md:w-24 h-1 bg-purple-600"></span>
				</h2>
				
				<div class="bg-white p-6 sm:p-8 md:p-10 lg:p-12 rounded-2xl sm:rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
					<div class="flex flex-wrap justify-center gap-6 sm:gap-8">
						@foreach($partners as $partner)
						@php
							$rawUrl = trim($partner->url ?? $partner->getMeta('url') ?? '');
							$url = null;
							if (!empty($rawUrl) && (filter_var($rawUrl, FILTER_VALIDATE_URL) || filter_var('https://' . $rawUrl, FILTER_VALIDATE_URL))) {
								$url = \Illuminate\Support\Str::startsWith($rawUrl, ['http://', 'https://']) ? $rawUrl : 'https://' . $rawUrl;
							}
						@endphp
						<div class="w-[calc(100%-2rem)] sm:w-[calc(50%-2rem)] md:w-[calc(33.333%-2rem)] lg:w-[calc(25%-2rem)] xl:w-[calc(20%-2rem)] flex items-center justify-center p-4 aspect-[4/3]">
							@if($url)
								<a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="w-full h-full flex items-center justify-center">
							@endif
								<img class="w-full h-full object-contain hover:-translate-y-1 transition-all duration-300"
									src="{{ $partner->getFirstMediaUrl('logo') }}"
									alt="{{ $partner->name }}" 
									loading="lazy"/>
							@if($url)
								</a>
							@endif
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
@endif