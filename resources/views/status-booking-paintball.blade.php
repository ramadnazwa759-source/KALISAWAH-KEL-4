@extends('layouts.app')

@section('title', 'Status Booking Paintball - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION (Decorative/Small) -->
    <section class="relative h-[100px] w-full overflow-hidden">
        <img src="{{ asset('images/wargame1.jpg') }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-black/40"></div>
    </section>

    <!-- STATUS SECTION -->
    <section id="status-booking" class="py-24 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-dark-navy mb-4">Status Pemesanan</h2>
                <div class="w-16 h-1.5 bg-secondary mx-auto rounded-full"></div>
            </div>

            <!-- MAIN STATUS CARD -->
            <div class="bg-white rounded-[32px] shadow-xl p-8 md:p-12 border border-gray-100 space-y-12">
                
                <!-- A. STATUS BADGE -->
                <div class="flex flex-col items-center text-center space-y-6">
                    <div class="inline-flex items-center gap-3 px-8 py-3 bg-yellow-50 text-yellow-600 rounded-full border border-yellow-100">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></span>
                        <span class="text-xl font-black uppercase tracking-widest">Menunggu</span>
                    </div>
                    
                    <div class="max-w-md">
                        <p class="text-gray-500 font-medium text-lg">
                            Menunggu, harap menunggu pembayaran sedang diproses oleh admin.
                        </p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- B. UPLOAD BUKTI PEMBAYARAN -->
                <div class="space-y-6 pb-8">
                    <h3 class="text-xl font-bold text-dark-navy flex items-center gap-3">
                        Upload Bukti Pembayaran
                    </h3>

                    <div class="bg-white border border-[#ddd] rounded-xl p-10 text-center hover:border-gray-400 hover:bg-gray-50/50 transition-all group cursor-pointer relative" 
                         id="drop-area">
                        <input type="file" id="fileElem" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="handleFiles(this.files)">
                        
                        <div id="upload-content" class="flex flex-col items-center justify-center space-y-4">
                            <!-- Icon -->
                            <div class="text-gray-300 text-5xl group-hover:text-primary transition-colors">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            
                            <!-- Text -->
                            <div class="space-y-1">
                                <h4 class="text-lg font-bold text-dark-navy">Klik / seret file ke sini</h4>
                                <p class="text-gray-400 text-sm">Upload bukti pembayaran</p>
                            </div>
                            
                            <p class="text-xs text-gray-400 font-medium">Format: JPG, PNG (Maks 2MB)</p>
                        </div>

                        <!-- Preview Container -->
                        <div id="preview-container" class="hidden flex flex-col items-center z-30 relative">
                            <div class="relative group/preview inline-block">
                                <img id="preview-img" src="" class="max-h-[250px] rounded-lg shadow-md border border-gray-100 mb-4">
                                <button type="button" onclick="resetUpload(event)" class="absolute -top-3 -right-3 bg-red-500 text-white w-8 h-8 rounded-full shadow-lg flex items-center justify-center hover:bg-red-600 transition-colors">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <p id="file-name" class="text-primary font-bold text-sm"></p>
                        </div>
                    </div>
                </div>

                <!-- C. FOOTER BUTTONS -->
                <div class="mt-10 flex flex-row flex-nowrap items-center justify-center gap-4 pt-6 pb-12">
                    <a href="{{ route('home') }}" 
                        class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl border border-blue-400 bg-white text-primary font-bold text-lg flex items-center justify-center hover:bg-blue-50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/20 active:scale-95 shadow-sm uppercase tracking-widest cursor-pointer">
                        Kembali
                    </a>
                    
                    <button type="button" onclick="finishBooking()"
                        style="background-color: #FFC236;"
                        class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl text-white font-bold text-lg flex items-center justify-center hover:bg-[#FFD15B] transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-yellow-500/30 active:scale-95 shadow-md uppercase tracking-widest gap-3 cursor-pointer">
                        <span>Konfirmasi</span>
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>



    <script>
        function handleFiles(files) {
            const file = files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-content').classList.add('hidden');
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('file-name').innerText = file.name;
                }
                reader.readAsDataURL(file);
            }
        }

        function resetUpload(e) {
            e.stopPropagation();
            document.getElementById('fileElem').value = '';
            document.getElementById('upload-content').classList.remove('hidden');
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('preview-img').src = '';
        }

        function finishBooking() {
            alert('Konfrimasi berhasil! Terimakasih telah melakukan pemesanan');
            localStorage.removeItem('booking_data');
            window.location.href = "{{ route('home') }}";
        }
    </script>
@endsection
