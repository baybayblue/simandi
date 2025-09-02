<header class="flex items-center justify-between px-6 py-4 bg-white border-b-2 border-gray-100">
    <div class="flex items-center">
        <h2 class="text-xl font-semibold text-gray-700">@yield('title')</h2>
    </div>

    <div class="flex items-center">
        <div class="relative">
            <button class="relative z-10 block h-10 w-10 overflow-hidden rounded-full shadow focus:outline-none" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <img class="h-full w-full object-cover" src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="Your avatar">
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10 hidden">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Logout</a>
                <form id="logout-form-header" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>

