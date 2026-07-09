<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Overview of company operations</h1>
                    <p class="text-slate-500 text-sm">Welcome back. Here is your team overview</p>
                </div>
                <!-- Search -->
                <div class="relative hidden sm:block">
                    <input type="text" placeholder="Search employees..." class="w-64 pl-4 pr-10 py-2 border border-slate-200 rounded-lg text-sm focus:ring-1 focus:ring-slate-900 outline-none">
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Employees</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">142</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Users</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">192</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Teams </p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">10</p>
                </div>
            </div>

</x-app-layout>