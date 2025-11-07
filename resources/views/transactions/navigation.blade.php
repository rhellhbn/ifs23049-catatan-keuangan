<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
        {{ __('Transaksi') }}
    </x-nav-link>
    <x-nav-link :href="route('transactions.statistics')" :active="request()->routeIs('transactions.statistics')">
        {{ __('Statistik') }}
    </x-nav-link>
</div>
<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
            {{ __('Transaksi') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('transactions.statistics')" :active="request()->routeIs('transactions.statistics')">
            {{ __('Statistik') }}
        </x-responsive-nav-link>
    </div>
    ...
</div>