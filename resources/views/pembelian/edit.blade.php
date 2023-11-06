<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Pembelian') }}
    </h2>
  </x-slot>
  @if (Session::has('status'))
    <div class="alert alert-{{ Session::get('status') }} w-1/2">
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <span>{{ Session::get('message') }}</span>
      <button class="close" onclick="closeAlert(this)">×</button>
    </div>
  @endif
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{ route('pembelian.update', $pembelian->id_pembelian) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <h2 class="text-2xl font-bold mb-4">Edit Pembelian</h2>
            <div class="mb-4">
              <label for="tgl_pembelian" class="block text-sm font-medium text-white">Tanggal Pembelian:</label>
              <input type="date" id="tgl_pembelian" name="tgl_pembelian" required
                value="{{ $pembelian->tgl_pembelian }}"
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            </div>

            <div class="mb-4">
              <label for="id_pemasok" class="block text-sm font-medium text-white">Nama Pemasok:</label>
              <select id="id_pemasok" name="id_pemasok" required
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
                <option value="{{ $pembelian->pemasok->id_pemasok }}">{{ $pembelian->pemasok->nama_pemasok }}</option>
                @foreach ($pemasok as $p)
                  <option value="{{ $p->id_pemasok }}">{{ $p->nama_pemasok }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-4">
              <label for="jumlah_produk" class="block text-sm font-medium text-white">Jumlah Produk:</label>
              <input type="number" id="jumlah_produk" name="jumlah_produk" required min="0"
                value="{{ $pembelian->jumlah_produk }}"
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
              Edit
            </button>
            <a href="/pembelian" class="btn">back</a>
          </form>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
