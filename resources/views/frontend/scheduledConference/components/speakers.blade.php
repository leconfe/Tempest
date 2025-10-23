@if ($currentScheduledConference?->speakers->isNotEmpty())
	<section id="speakers" class="py-6 sm:py-8 md:py-12 bg-white">
		<div class="container mx-auto px-4">
			<div class="max-w-7xl mx-auto">
				<h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center mb-6 sm:mb-8 md:mb-10 relative inline-block w-full text-gray-900">
					Speakers
					<span class="garis absolute left-1/2 -bottom-3 sm:-bottom-4 transform -translate-x-1/2 w-16 sm:w-20 md:w-24 h-1 bg-purple-600"></span>
				</h3>
				
				<div class="space-y-12 sm:space-y-16 md:space-y-20">
					@foreach ($currentScheduledConference->speakerRoles as $role)
					@if ($role->speakers->isNotEmpty())
					<div class="speak-title bg-white rounded-2xl sm:rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] p-6 sm:p-8 md:p-2 lg:p-16 transform hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)] transition-all duration-500">
						<h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-8 sm:mb-12 md:mb-16 flex items-center justify-center text-gray-900 md:mt-8 lg:mt-2">
							<span class="relative">
								{{ $role->name }}
								<span class="garis absolute -bottom-1 sm:-bottom-2 left-0 w-full h-0.5"></span>
							</span>
							<svg class="speak-icon w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 ml-2 sm:ml-3" fill="currentColor" viewBox="0 0 100 100">
								<path d="M100 34.2c-.4-2.6-3.3-4-5.3-5.3-3.6-2.4-7.1-4.7-10.7-7.1-8.5-5.7-17.1-11.4-25.6-17.1-2-1.3-4-2.7-6-4-1.4-1-3.3-1-4.8 0-5.7 3.8-11.5 7.7-17.2 11.5L5.2 29C3 30.4.1 31.8 0 34.8c-.1 3.3 0 6.7 0 10v16c0 2.9-.6 6.3 2.1 8.1 6.4 4.4 12.9 8.6 19.4 12.9 8 5.3 16 10.7 24 16 2.2 1.5 4.4 3.1 7.1 1.3 2.3-1.5 4.5-3 6.8-4.5 8.9-5.9 17.8-11.9 26.7-17.8l9.9-6.6c.6-.4 1.3-.8 1.9-1.3 1.4-1 2-2.4 2-4.1V37.3c.1-1.1.2-2.1.1-3.1 0-.1 0 .2 0 0zM54.3 12.3L88 34.8 73 44.9 54.3 32.4V12.3zm-8.6 0v20L27.1 44.8 12 34.8l33.7-22.5zM8.6 42.8L19.3 50 8.6 57.2V42.8zm37.1 44.9L12 65.2l15-10.1 18.6 12.5v20.1zM50 60.2L34.8 50 50 39.8 65.2 50 50 60.2zm4.3 27.5v-20l18.6-12.5 15 10.1-33.6 22.4zm37.1-30.5L80.7 50l10.8-7.2-.1 14.4z"/>
							</svg>
						</h2>
						<div class="items-center justify-center gap-6 sm:gap-8 md:gap-12 flex flex-wrap">
							@foreach ($role->speakers as $speaker)
							<div class="w-full max-w-xs flex">
								<div class="bg-gradient-to-b from-white to-gray-50/50 rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 transition duration-500 transform hover:-translate-y-2 hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-100 flex flex-col w-full">
									<div class="relative mb-4 sm:mb-5 md:mb-6 flex justify-center">
										<div class="w-28 h-28 sm:w-32 sm:h-32 md:w-40 md:h-40 flex-shrink-0">
											<img class="w-full h-full rounded-full object-cover shadow-lg border-2 sm:border-3 md:border-4 border-white ring-2 sm:ring-3 md:ring-4 ring-gray-100 group-hover:ring-indigo-300 transition-all duration-300"
												src="{{ $speaker->getFilamentAvatarUrl() }}"
												alt="{{ $speaker->fullName }}" />
										</div>
									</div>
									<div class="text-center flex-grow flex flex-col justify-between min-h-[100px]">
										<div>
											<h4 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-900 line-clamp-2 min-h-[2.5em]">{{ $speaker->fullName }}</h4>
											@if ($speaker->getMeta('affiliation'))
											<p class="text-xs sm:text-sm text-gray-600 px-2 sm:px-3 md:px-4 leading-relaxed line-clamp-3">{{ $speaker->getMeta('affiliation') }}</p>
											@endif
										</div>
										@if($speaker->getMeta('scopus_url') || $speaker->getMeta('google_scholar_url') || $speaker->getMeta('orcid_url'))
										<div class="flex justify-center items-center space-x-4 pt-4 border-t border-gray-100">
											@if($speaker->getMeta('orcid_url'))
											<a href="{{ $speaker->getMeta('orcid_url') }}" target="_blank" 
												class="text-lime-600 hover:text-lime-700 transition-all duration-300 transform hover:-translate-y-1">
												<x-academicon-orcid class="w-7 h-7 opacity-80 hover:opacity-100" />
											</a>
											@endif

											@if($speaker->getMeta('google_scholar_url'))
											<a href="{{ $speaker->getMeta('google_scholar_url') }}" target="_blank" 
												class="text-blue-600 hover:text-blue-700 transition-all duration-300 transform hover:-translate-y-1">
												<x-academicon-google-scholar class="w-7 h-7 opacity-80 hover:opacity-100" />
											</a>
											@endif

											@if($speaker->getMeta('scopus_url'))
											<a href="{{ $speaker->getMeta('scopus_url') }}" target="_blank" 
												class="text-orange-600 hover:text-orange-700 transition-all duration-300 transform hover:-translate-y-1">
												<x-academicon-scopus class="w-7 h-7 opacity-80 hover:opacity-100" />
											</a>
											@endif
										</div>
										@endif
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					@endif
					@endforeach
				</div>
			</div>
		</div>
	</section>
@endif