<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <div
            class="flex flex-col items-center justify-center w-full bg-white border border-gray-200 rounded-lg shadow md:flex-row hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover h-auto w-1/3 md:rounded-none md:rounded-l-lg"
              src="{{ 'assets/Welcome-amico.png' }}" alt="">
            <div class="flex flex-col justify-between p-4 leading-normal">
              <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Welcome
                {{ Auth::user()->name }}</h5>
              <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">waktunya mengontrol data perusahaan</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
