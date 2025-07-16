<x-layout>
    <div class="flex flex-col mx-[5vw] my-[2vw]">
        <h1 class="text-[2vw] font-bold mb-[3vw]">Carbon Footprint Calculator</h1>

        <div class="flex flex-col items-center">
            <h2 class="text-[1.5vw] font-bold mb-[1.5vw]">Your Carbon Footprint</h2>

            @php
                $isGood = $carbon <= 60;
            @endphp
            <div class="relative flex flex-col items-center justify-center">
                <!-- SVG Half Circle -->
                <svg class="w-[25vw] h-[12.5vw]" viewBox="0 0 200 100">
                    <!-- Track -->
                    <path d="M10,100 A90,90 0 0,1 190,100" fill="transparent" stroke="#e5e7eb" stroke-width="15"
                       stroke-linecap="round" />
                    <!-- Progress -->
                    <path id="progressArc" d="M10,100 A90,90 0 0,1 190,100" fill="transparent" stroke="{{ $isGood ? '#3E6137' : '#D1764F' }}"
                        stroke-width="15" stroke-dasharray="283" stroke-dashoffset="141.5" stroke-linecap="round" />
                </svg>

                <!-- Value & Label -->
                <div class="absolute top-[5vw] text-center">
                    <div class="text-[4vw] font-bold" id="progressValue">{{ $carbon }}</div>
                    <div class="text-[1.5vw] font-bold mt-[-0.5vw]" id="progressLabel">{{ $isGood ? 'GOOD' : 'POOR' }}</div>
                </div>

                <!-- Min & Max Labels -->
                <div class="flex justify-between w-[28vw] mt-[1.5vw]">
                    <span class="text-white text-[1.1vw] font-bold w-[5vw] text-center px-[0.5vw] py-[0.25vw] rounded-[0.5vw] bg-green-2">0</span>
                    <span class="text-white text-[1.1vw] font-bold w-[5vw] text-center px-[0.5vw] py-[0.25vw] rounded-[0.5vw] bg-orange-1">100</span>
                </div>

                <p id="resultDesc" class="text-[1.4vw] font-bold text-center mt-[3vw] w-[70%]">
                    {{ $isGood ? 
                        'Kamu Luar Biasa! 🌍 Kamu sudah berada di jalur yang tepat, teruskan kebiasaan ramah lingkunganmu'
                        : 'Ups! Jejak Karbonmu Perlu Diperbaiki. Tapi tenang—setiap langkah kecil menuju gaya hidup lebih hijau sangat berarti. Yuk, mulai sekarang!'
                    }} 
                </p>
                
                <div class="flex flex-col items-center justify-center mt-[2vw]">
                    <h2 class="text-[1.8vw] font-bold mb-[1.5vw]">Rekomendasi :</h2>
                    @if ($carbon <= 60)
                        <div id="recommendBaik" class="flex flex-wrap justify-between w-[70%] bg-yellow-3 px-[3vw] py-[2vw] rounded-[1vw]">
                            <div class="flex flex-col justify-center items-center w-[50%] p-[2vw] border-r border-b border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-shield text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Pertahankan Kebiasaan</h4>
                                <p class="text-green-2 font-bold text-center">Pertahankan kebiasaan ramah lingkunganmu dan jadilah inspirasi bagi orang-orang di sekitarmu</p>
                            </div>
        
                            <div class="flex flex-col justify-center items-center w-[50%] p-[2vw] border-l border-b border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-chart-line text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Tingkatkan Dampak Positif</h4>
                                <p class="text-green-2 font-bold text-center">Cobalah langkah baru seperti mengurangi limbah makanan, menggunakan transportasi hijau, atau mendukung produk lokal</p>
                            </div>

                            <div class="flex flex-col justify-center items-center w-[50%] p-[2vw] border-r border-t border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-user-group text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Ajak Orang Lain</h4>
                                <p class="text-green-2 font-bold text-center">Bagikan semangatmu kepada keluarga dan teman agar semakin banyak yang peduli pada lingkungan</p>
                            </div>

                            <div class="flex flex-col justify-center items-center w-[50%] p-[2vw] border-l border-t border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-tree text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Dukung Program Lingkungan</h4>
                                <p class="text-green-2 font-bold text-center">Ikut serta dalam kegiatan seperti penanaman pohon, daur ulang, atau bersih-bersih lingkungan sekitar</p>
                            </div>
                        </div>
                    @else
                        <div id="recommendBuruk" class="grid grid-cols-3 bg-yellow-3 px-[3vw] py-[2vw] rounded-[1vw]">
        
                            <div class="flex flex-col justify-center items-center p-[2vw] border-r border-b border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-bolt text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Tingkatkan Efisiensi Energi di Rumah</h4>
                                <p class="text-green-2 font-bold text-center">Mengganti peralatan lama dengan model hemat energi dan memaksimalkan isolasi rumah membantu menurunkan konsumsi listrik dan emisi karbon</p>
                            </div>

                            <div class="flex flex-col justify-center items-center p-[2vw] border-x border-b border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-cookie-bite text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Mengubah Kebiasaan Makan</h4>
                                <p class="text-green-2 font-bold text-center">Mengurangi konsumsi daging dan produk hewani serta lebih sering memilih makanan lokal dan musiman dapat signifikan menurunkan jejak karbon panganmu.</p>
                            </div>

                            <div class="flex flex-col justify-center items-center p-[2vw] border-l border-b border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-bus text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Bepergian yang Hemat Energi</h4>
                                <p class="text-green-2 font-bold text-center">Mengganti kendaraan pribadi dengan transportasi umum, bersepeda, atau jalan kaki serta memperbanyak carpool dapat mengurangi emisi dari perjalanan</p>
                            </div>

                            <div class="flex flex-col justify-center items-center p-[2vw] border-r border-t border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-recycle text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Mendaur Ulang Sampah</h4>
                                <p class="text-green-2 font-bold text-center">Memilah dan mendaur ulang sampah rumah tangga membantu mengurangi jumlah limbah dan menghemat energi yang diperlukan untuk memproduksi barang-barang baru</p>
                            </div>

                            <div class="flex flex-col justify-center items-center p-[2vw] border-x border-t border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-water text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Mengurangi Penggunaan Air</h4>
                                <p class="text-green-2 font-bold text-center">Memasang alat hemat air dan memperbaiki kebocoran membantu mengurangi energi yang dipakai untuk memompa dan mengolah air bersih</p>
                            </div>

                            <div class="flex flex-col justify-center items-center p-[2vw] border-l border-t border-green-2">
                                <div class="w-[5vw] h-[5vw] flex justify-center items-center rounded-[1vw] bg-green-2 mb-[1vw]">
                                    <i class="fa-solid fa-bag-shopping text-[2.5vw] text-white"></i>
                                </div>
                                <h4 class="text-orange-1 font-bold text-[1.3vw] mb-[0.5vw]">Mengurangi Penggunaan Plastik</h4>
                                <p class="text-green-2 font-bold text-center">Membawa tas belanja, botol minum, dan wadah makanan sendiri dapat menekan produksi plastik dan emisi karbon dari proses daur ulang atau pembuangannya.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const arc = document.getElementById('progressArc');
        const valueText = document.getElementById('progressValue');
        const labelText = document.getElementById('progressLabel');
        const resultDesc = document.getElementById('resultDesc');
        const goodRecommend = document.getElementById('recommendBaik');
        const value = parseFloat(valueText.textContent);
        const progress = value / 178 * 100;

        const circumference = 283;
        const offset = circumference - (circumference * progress) / 100;
        arc.style.strokeDashoffset = offset;
    </script>
    
</x-layout>
