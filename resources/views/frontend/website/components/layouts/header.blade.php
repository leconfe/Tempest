@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationMenu = app()->getNavigationItems('user-navigation-menu');
    $isGlobalNavigationEnabled = App\Facades\Plugin::getPlugin('Tempest')->getSetting('global_navigation')
@endphp

@if($isGlobalNavigationEnabled)
<div class="navbar-publisher navbar-container bg-white shadow z-[51] text-gray-800">
    <div class="navbar mx-auto max-w-7xl items-center h-full">
        <div class="navbar-start items-center gap-x-4 w-max">
            <x-website::logo :headerLogo="app()->getSite()->getFirstMedia('logo')?->getAvailableUrl(['thumb', 'thumb-xl'])" :headerLogoAltText="app()->getSite()->getMeta('name')" :homeUrl="url('/')"/>
            @if(App\Models\Conference::exists())
                @livewire(App\Livewire\GlobalNavigation::class)
            @endif

        </div>
        
        <div class="navbar-end ms-auto gap-x-4 hidden lg:inline-flex">
            <x-website::navigation-menu :items="$userNavigationMenu" class="text-gray-800" />
        </div>
    </div>
</div>
    
@endif

@if(app()->getCurrentConference() || app()->getCurrentScheduledConference())
    <div id="navbar" class="navbar-container bg-black/50 absolute w-full text-white shadow z-50">
        <div class="backdrop-blur-md py-5 transition-all duration-100">
            <div class="navbar mx-auto max-w-7xl justify-between">
                <div class="navbar-start items-center w-max gap-2">
                    <x-website::navigation-menu-mobile />
                    <x-website::logo :headerLogo="$headerLogo"/>
                </div>
                <div class="navbar-end hidden lg:flex relative z-10 w-max">
                    <x-website::navigation-menu :items="$primaryNavigationItems" />
                </div>
                @if(!$isGlobalNavigationEnabled)
                <div class="user-nav flex items-center">
                    <x-tempest::navigation-menu 
                        :items="$userNavigationMenu"
                        class="flex items-center gap-4" />
                </div>
                @endif
            </div>
        </div>
        
    </div>
@endif

<script>

function handleNavbarScroll() {
    const navbar = document.getElementById('navbar');
    const scrollPosition = window.scrollY;

    if (scrollPosition > 50) {
        navbar.classList.remove('absolute')
        navbar.classList.add('sticky', 'top-0')
        navbar.classList.remove('bg-black/50', 'text-white');
        navbar.classList.add('bg-white', 'text-black');
    } else {
        navbar.classList.remove('sticky', 'top-0')
        navbar.classList.add('absolute')
        navbar.classList.remove('bg-white', 'text-black');
        navbar.classList.add('bg-black/50', 'text-white');
    }
}

window.addEventListener('scroll', handleNavbarScroll);
handleNavbarScroll();
</script>
