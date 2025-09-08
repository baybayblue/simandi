<!-- Sidebar -->
<div x-show="sidebarOpen" @click.away="sidebarOpen = false" x-cloak 
     class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 text-white transform transition duration-300 ease-in-out flex flex-col shadow-lg lg:translate-x-0 lg:static lg:inset-0" 
     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
    
    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4">
            <img class="h-10 w-auto mr-3" src="{{ asset('dist/img/simandi-logo.png') }}" alt="Simandi Laundry Logo" style="border-radius: 50%; background-color: white; padding: 4px;">
            <span class="text-xl font-semibold text-gray-200">Simandi Laundry</span>
        </div>

        <nav class="mt-8 flex-1 px-2 space-y-1">
            <h3 class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu Utama</h3>
            
            {{-- Logika "Pintar": Tampilkan menu berdasarkan peran --}}
            @if(Auth::user()->role === 'admin')
                {{-- MENU UNTUK ADMIN --}}
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="layout-dashboard" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Dashboard
                </a>
                <a href="{{ route('admin.customers.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.customers.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="users" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Pelanggan
                </a>
                <a href="{{ route('admin.services.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.services.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="gem" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Layanan
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="shopping-cart" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Transaksi
                </a>
                <a href="{{ route('admin.reports.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.reports.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="file-text" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Laporan
                </a>
                 <a href="{{ route('admin.activity_logs.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.activity-logs.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="history" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Log Aktivitas
                </a>
            @else
                {{-- MENU UNTUK PELANGGAN --}}
                 <a href="{{ route('pelanggan.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('pelanggan.dashboard') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="layout-dashboard" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Dashboard
                </a>
                <a href="{{ route('pelanggan.transactions.create') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('pelanggan.transactions.create') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="plus-circle" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Buat Pesanan
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.transactions.index') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="list" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Riwayat Transaksi
                </a>
                 <a href="{{ route('pelanggan.laporan.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('pelanggan.laporan.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i data-lucide="file-text" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i> Laporan Saya
                </a>
            @endif
        </nav>
        
        <div class="mt-6 px-2 space-y-1">
             <h3 class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Akun</h3>
             <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                <i data-lucide="log-out" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300"></i>
                Logout
            </a>
            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

