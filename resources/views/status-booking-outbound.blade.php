@extends('layouts.app')

@section('title', 'Status Booking Outbound - Kalisawah Adventure')

@section('content')
    <!-- STATUS & UPLOAD SECTION -->
    <section class="py-24 px-6 scroll-mt-20 mt-16 bg-white min-h-[80vh]">
        <div class="max-w-[1000px] mx-auto">
            
            <div class="text-center mb-10">
                <h1 class="text-4xl md:text-5xl font-black text-dark-navy mb-4">Status Pemesanan</h1>
                <div class="w-16 h-1.5 bg-secondary mx-auto rounded-full"></div>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm border border-gray-200 p-8 md:p-12">
                
                <!-- STATUS CARD -->
                <div class="text-center mb-12">
                    <div class="inline-block border border-gray-400 rounded-full px-8 py-3 mb-6">
                        <span class="text-gray-700 font-bold uppercase tracking-widest text-lg">Menunggu</span>
                    </div>
                    <p class="text-gray-500 font-medium text-lg max-w-md mx-auto">
                        Menunggu, harap menunggu pembayaran sedang diproses oleh admin.
                    </p>
                </div>

                <!-- UPLOAD BUKTI PEMBAYARAN -->
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-dark-navy mb-4">Upload Bukti Pembayaran</h3>
                    
                    <div class="relative w-full border border-gray-400 rounded-xl bg-white p-6 md:p-12 hover:border-blue-400 transition-colors group cursor-pointer" onclick="document.getElementById('buktiPembayaran').click()">
                        <input type="file" id="buktiPembayaran" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/png, image/jpeg">
                        
                        <!-- Header / default file input look at top left -->
                        <div class="absolute top-4 left-4 text-sm text-gray-700 z-0 flex items-center gap-2">
                            <span class="bg-gray-100 border border-gray-300 px-3 py-1 rounded text-xs">Choose File</span>
                            <span id="fileNameTop" class="text-gray-500">No file chosen</span>
                        </div>

                        <div class="text-center relative z-0 flex flex-col items-center justify-center mt-6">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 mb-3 group-hover:text-blue-400 transition-colors"></i>
                            <h4 class="font-bold text-dark-navy text-lg">Klik / seret file ke sini</h4>
                            <p class="text-gray-500 mt-1">Upload bukti pembayaran</p>
                            <p class="text-gray-400 text-xs mt-3">Format: JPG, PNG (Maks 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- BOTTOM BUTTONS -->
                <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                    <a href="{{ route('outbound') }}" class="w-full md:flex-1 h-[50px] rounded-xl border-2 border-blue-500 bg-white text-blue-600 font-bold text-lg flex items-center justify-center hover:bg-blue-50 transition-all duration-200 active:scale-[0.98] uppercase tracking-widest">
                        KEMBALI
                    </a>
                    
                    <button type="button" onclick="konfirmasiStatus()" style="background-color: #FFC236;" class="w-full md:flex-1 h-[50px] rounded-xl text-white font-bold text-lg flex items-center justify-center hover:bg-[#FFD15B] transition-all duration-200 active:scale-[0.98] uppercase tracking-widest gap-2">
                        <span>KONFIRMASI</span>
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- SUCCESS POPUP -->
        <div id="successPopup" class="fixed top-8 left-1/2 -translate-x-1/2 z-[300] flex items-center justify-between gap-4 bg-[#eaffec] border border-[#a3e6b5] text-gray-800 px-6 py-4 rounded-full shadow-xl shadow-green-900/10 transition-all duration-500 opacity-0 -translate-y-10 scale-95 pointer-events-none">
            <span class="font-bold text-lg tracking-wide pr-4 border-r border-[#a3e6b5]">Booking Berhasil</span>
            <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>

        <!-- LOADING OVERLAY -->
        <div id="loadingOverlayStatus" class="fixed inset-0 z-[200] bg-primary/95 hidden items-center justify-center flex-col text-white backdrop-blur-md">
            <div class="w-24 h-24 border-8 border-white/20 rounded-full flex items-center justify-center mb-8 relative">
                <div class="absolute inset-0 border-8 border-secondary border-t-transparent rounded-full animate-spin"></div>
            </div>
            <h3 class="text-3xl font-black mb-2">Memproses...</h3>
            <p class="text-blue-200">Mohon tunggu sebentar...</p>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle file upload UI
            document.getElementById('buktiPembayaran').addEventListener('change', function(e) {
                if(e.target.files.length > 0) {
                    const file = e.target.files[0];
                    document.getElementById('fileNameTop').innerText = file.name;
                } else {
                    document.getElementById('fileNameTop').innerText = 'No file chosen';
                }
            });
        });

        function konfirmasiStatus() {
            document.getElementById('loadingOverlayStatus').classList.remove('hidden');
            document.getElementById('loadingOverlayStatus').classList.add('flex');
            
            setTimeout(() => {
                document.getElementById('loadingOverlayStatus').classList.add('hidden');
                document.getElementById('loadingOverlayStatus').classList.remove('flex');
                
                const popup = document.getElementById('successPopup');
                popup.classList.remove('opacity-0', '-translate-y-10', 'scale-95');
                popup.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                
                setTimeout(() => {
                    popup.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
                    popup.classList.add('opacity-0', '-translate-y-10', 'scale-95');
                    
                    setTimeout(() => {
                        window.location.href = "{{ route('outbound') }}";
                    }, 500);
                }, 3000);
            }, 1500);
        }
    </script>
@endsection
