<div class="hidden md:flex flex-col w-64 bg-gray-800 text-gray-100">
    <div class="flex items-center justify-center h-20 shadow-md">
        <img src="{{ asset('dist/img/simandi-logo.png') }}" alt="Logo Simandi" class="h-10 w-10 bg-white rounded-full p-1 mr-3">
        <h1 class="text-2xl font-bold text-white">Simandi</h1>
    </div>
    <nav class="flex-1 px-4 py-4 space-y-2">
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</p>
        
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.customers.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i data-lucide="users" class="w-5 h-5 mr-3"></i>
            Pelanggan
        </a>
        <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i data-lucide="concierge-bell" class="w-5 h-5 mr-3"></i>
            Layanan
        </a>
        <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i data-lucide="shopping-cart" class="w-5 h-5 mr-3"></i>
            Transaksi
        </a>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i data-lucide="file-text" class="w-5 h-5 mr-3"></i>
            Laporan
        </a>
        <a href="{{ route('admin.activity_logs.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.activity_logs.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i data-lucide="history" class="w-5 h-5 mr-3"></i>
            Log Aktivitas
        </a>

        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</p>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 hover:bg-gray-700 hover:text-white">
                <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>
</div>

