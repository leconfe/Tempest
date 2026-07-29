@props(['sponsorLevels', 'sponsorsWithoutLevel'])

@if($sponsorLevels->isNotEmpty() || $sponsorsWithoutLevel->isNotEmpty())
	<section class="bg-white py-12 sm:py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div class="max-w-[1400px] mx-auto">
				<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center mb-8 sm:mb-10 relative inline-block w-full text-gray-900">
					Sponsors
					<span class="garis absolute left-1/2 -bottom-3 sm:-bottom-4 transform -translate-x-1/2 w-16 sm:w-20 md:w-24 h-1 bg-purple-600"></span>
				</h2>
				
				<div class="space-y-12 sm:space-y-16 md:space-y-20">
					@if($sponsorsWithoutLevel->isNotEmpty())
					<div class="bg-white p-4 sm:p-6 md:p-8 lg:p-12 rounded-2xl sm:rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
						<div class="flex flex-wrap justify-center gap-4 sm:gap-6 md:gap-8">
							@foreach($sponsorsWithoutLevel as $sponsor)
							@if(!$sponsor->getFirstMedia('logo'))
							@continue
							@endif
							@php
								$url = $sponsor->getMeta('url');
							@endphp
							<div class="w-[calc(100%-2rem)] sm:w-[calc(50%-2rem)] md:w-[calc(33.333%-2rem)] lg:w-[calc(25%-2rem)] xl:w-[calc(20%-2rem)] flex items-center justify-center p-4 aspect-[4/3]">
								@if($url)
									<a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="w-full h-full flex items-center justify-center">
								@endif
									<img class="w-full h-full object-contain hover:-translate-y-1 transition-all duration-300" 
										src="{{ $sponsor->getFirstMediaUrl('logo') }}"
										alt="{{ $sponsor->name }}"
										loading="lazy" />
								@if($url)
									</a>
								@endif
							</div>
							@endforeach
						</div>
					</div>
					@endif
				
					@foreach ($sponsorLevels as $sponsorLevel)
					<div class="bg-white p-4 sm:p-6 md:p-8 lg:p-12 rounded-2xl sm:rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
						<h3 class="text-xl sm:text-2xl font-bold mb-6 sm:mb-8 md:mb-10 relative inline-block text-gray-900">
							{{ $sponsorLevel->name }}
							<span class="absolute -bottom-2 left-0 w-full h-0.5 bg-purple-500"></span>
						</h3>
						<div class="flex flex-wrap justify-center gap-4 sm:gap-6 md:gap-8">
							@foreach($sponsorLevel->stakeholders as $sponsor)
							@if(!$sponsor->getFirstMedia('logo'))
							@continue
							@endif
							@php
								$url = $sponsor->getMeta('url');
							@endphp
							<div class="w-[calc(100%-2rem)] sm:w-[calc(50%-2rem)] md:w-[calc(33.333%-2rem)] lg:w-[calc(25%-2rem)] xl:w-[calc(20%-2rem)] flex items-center justify-center p-4 aspect-[4/3]">
								@if($url)
									<a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="w-full h-full flex items-center justify-center">
								@endif
									<img class="w-full h-full object-contain hover:-translate-y-1 transition-all duration-300" 
										src="{{ $sponsor->getFirstMediaUrl('logo') }}"
										alt="{{ $sponsor->name }}"
										loading="lazy" />
								@if($url)
									</a>
								@endif
							</div>
							@endforeach
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
@endif