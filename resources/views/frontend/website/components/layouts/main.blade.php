@props([
    'sidebars' => \App\Facades\SidebarFacade::get(),
])
<div class="page-container">
    @if(Route::currentRouteName() == 'livewirePageGroup.scheduledConference.pages.home')
        <x-tempest::layouts.banner/>
    @endif
    <div class="mt-5 mb-20">    
        {{ $slot }}
    </div>
    <script>
        const endDate = new Date("{{ $currentScheduledConference->date_start?->format('Y-m-d H:i:s') }}").getTime();
        const now = new Date().getTime();
        const timeLeft = endDate - now;
        function updateCountdown() {
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            document.getElementById('days').innerText = days.toString().padStart(2, '0');
            document.getElementById('hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2, '0');
            if (timeLeft < 0) {
                console.log(timeLeft)
                clearInterval(countdownTimer);
                document.querySelector('.countdown-con').innerHTML = `
                    <div class="cd-passed p-2 sm:p-3 text-center rounded-lg shadow-lg">
                        <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-2 sm:mb-4 animate__animated animate__fadeIn">
                            Conference has passed!
                        </h2>
                        <p class="text-gray-200 text-base sm:text-lg">
                            Thank you for your interest!
                        </p>
                    </div>
                `;
            }
        }
        const countdownTimer = setInterval(updateCountdown, 1000);


        
        if(!endDate){
            document.querySelector('.countdown-con').innerHTML = `
            <div class="cd-passed p-2 sm:p-3 text-center rounded-lg shadow-lg">
                <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-2 sm:mb-4 animate__animated animate__fadeIn">
                    Conference date not set!
                </h2>
                <p class="text-gray-200 text-base sm:text-lg">
                    Please check back later.
                </p>
            </div>
            `;
        } else {
            updateCountdown(); // Initial call
        }

    </script>
</div>