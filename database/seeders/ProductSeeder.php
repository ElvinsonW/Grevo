<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $product = Product::create([
            "name" => "Deodoran Batu Tawas", 
            "slug" => "deodoran-batu-tawas", 
            "product_category_id" => 3, 
            "weight" => 180, 
            "material" => "Kalium aluminium sulfat alami (mineral bumi)", 
            "process" => "Batu tawas berasal dari tambang mineral alami. Setelah ditambang, mineral diproses melalui metode pemurnian fisik seperti pencucian dan pemotongan tanpa menggunakan bahan kimia tambahan. Batu tawas kemudian dikeringkan secara alami untuk mempertahankan kualitasnya. Produk ini dikemas dengan kertas daur ulang atau tanpa kemasan sama sekali untuk mengurangi limbah.", 
            "certification" => "Ekolabel Indonesia", 
            "description" => "Batu tawas alami adalah deodoran mineral murni yang efektif dan bebas bahan kimia berbahaya. Ramah lingkungan karena proses produksinya minimal dan dapat terurai secara alami, mengurangi jejak karbon Anda. Juga berfungsi sebagai astringen dan penghenti pendarahan kecil",
            "sold" => 50
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/BatuTawas.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BTU-TWS-1",
            "price" => 20000,
            "stock" => 100
        ]);

        $product = Product::create([
            "name" => "Reusable Cotton Pad", 
            "slug" => "reuseable-cotton-pad", 
            "product_category_id" => 1, 
            "weight" => 40, 
            "material" => "Kalium aluminium sulfat alami (mineral bumi)", 
            "process" => "Kapas organik ditanam tanpa pestisida atau bahan kimia berbahaya. Setelah dipanen, kapas diproses menjadi benang dan ditenun menjadi kain. Kain ini dipotong dan dijahit menjadi bantalan kapas yang lembut. Proses ini menghindari penggunaan pemutih dan pewarna sintetis untuk menjaga keamanannya bagi kulit dan lingkungan.", 
            "certification" => "GOTS (Global Organic Textile Standard)", 
            "description" => "Kapas kain organik yang lembut dan dapat dicuci ulang, sangat cocok untuk membersihkan wajah, mengaplikasikan toner, atau kebutuhan bayi. Mengurangi limbah kapas sekali pakai secara drastis, menjadikannya pilihan berkelanjutan untuk rutinitas kecantikan dan kebersihan Anda",
            "sold" => 100
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/KapasKain.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "KPS-KIN-1",
            "price" => 30000,
            "stock" => 50
        ]);

        $product = Product::create([
            "name" => "Sikat Gigi", 
            "slug" => "sikat-gigi", 
            "product_category_id" => 3, 
            "weight" => 20, 
            "material" => "Gagang yang biodegradable, bulu sikat nilon bebas BPA atau bulu sikat dari arang bambu", 
            "process" => "Gagang sikat gigi dibuat dari bahan biodegradable seperti bambu, yang dipotong dan dihaluskan secara manual. Bulu sikat terbuat dari nilon bebas BPA atau arang bambu yang aman bagi kesehatan. Semua komponen dirakit dengan presisi dan dikemas dalam kotak kertas daur ulang untuk menghindari limbah plastik.", 
            "certification" => "FSC (Forest Stewardship Council)", 
            "description" => "Sikat gigi kayu ini adalah alternatif ramah lingkungan yang sempurna untuk sikat gigi plastik. Gagangnya biodegradable dan bulu sikatnya efektif membersihkan gigi. Membantu Anda mengurangi sampah plastik sambil menjaga kebersihan mulut",
            "sold" => 200
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/SikatGigi.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "SKT-GG-1",
            "price" => 20000,
            "stock" => 100
        ]);

        $product = Product::create([
            "name" => "Pasta Gigi", 
            "slug" => "pasta-gigi", 
            "product_category_id" => 3, 
            "weight" => 250, 
            "material" => "Kalsium karbonat, xylitol, baking soda, sodium cocoyl isethionate, mint alami, dll", 
            "process" => "Bahan utama seperti kalsium karbonat dan xylitol dicampur dengan baking soda dan minyak mint alami. Proses ini dilakukan tanpa bahan kimia sintetis atau pewarna. Pasta gigi kemudian dikemas dalam tube ramah lingkungan yang terbuat dari material yang dapat terurai atau didaur ulang.", 
            "certification" => "COSMOS Natural/Organic", 
            "description" => "Pasta gigi ini adalah inovasi tanpa limbah yang membersihkan gigi secara efektif dan menyegarkan napas. Cukup kunyah satu tablet, sikat, dan rasakan perbedaannya. Bebas fluoride, sulfat, dan kemasan plastik, mendukung gaya hidup zero waste",
            "sold" => 30
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/PastaGigi.jpg"
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "PST-GG-50",
            "price" => 11000,
            "stock" => 50
        ]);

        Size::create([
            "product_variant_id" => $variant->id,
            "name" => "50 gr" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "PST-GG-100",
            "price" => 20000,
            "stock" => 50
        ]);

        Size::create([
            "product_variant_id" => $variant->id,
            "name" => "100 gr" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "PST-GG-200",
            "price" => 35000,
            "stock" => 50
        ]);

        Size::create([
            "product_variant_id" => $variant->id,
            "name" => "200 gr" 
        ]);


        $product = Product::create([
            "name" => "ToteBag Kanvas", 
            "slug" => "totebag-kanvas", 
            "product_category_id" => 5, 
            "weight" => 400, 
            "material" => "100% kanvas katun organik bersertifikat", 
            "process" => "Penanaman kapas organik, penenunan kanvas, pemotongan, penjahitan, dan finishing. Dicetak dengan tinta ramah lingkungan", 
            "certification" => "GOTS (Global Organic Textile Standard)", 
            "description" => "Totebag kanvas katun organik ini adalah pengganti kantong plastik sekali pakai yang stylish dan berkelanjutan. Kuat, tahan lama, dan serbaguna untuk belanja, membawa buku, atau penggunaan sehari-hari. Pilihan sadar lingkungan untuk mengurangi jejak plastik Anda",
            "sold" => 75
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/ToteBag.jpg"
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "TBG-KVS-MRH",
            "price" => 85000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Merah Maroon" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "TBG-KVS-AQU",
            "price" => 85000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Aqua" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "TBG-KVS-BGE",
            "price" => 85000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Beige" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "TBG-KVS-BRT",
            "price" => 85000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Biru Tua" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "TBG-KVS-HJU",
            "price" => 85000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Hijau Muda" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "TBG-KVS-CKT",
            "price" => 85000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Cokelat" 
        ]);

        $product = Product::create([
            "name" => "Sabun Mandi Batang", 
            "slug" => "sabun-mandi-batang", 
            "product_category_id" => 3, 
            "weight" => 120, 
            "material" => "Minyak kelapa, minyak sawit, soda api (NaOH), gliserin, pewangi, pewarna, ekstrak alami", 
            "process" => "Proses pembuatan sabun batang dimulai dengan mencampur minyak alami seperti kelapa atau zaitun dengan soda api untuk memicu reaksi saponifikasi. Pewarna dan pewangi dari ekstrak tumbuhan ditambahkan sebelum campuran dituangkan ke dalam cetakan. Sabun ini kemudian dibiarkan mengeras secara alami sebelum dipotong dan dikemas", 
            "certification" => "Ekolabel Indonesia dan RSPO (Roundtable on Sustainable Palm Oil)", 
            "description" => "Sabun mandi batang dengan busa melimpah, membersihkan kulit secara lembut tanpa membuatnya kering. Diperkaya dengan ekstrak alami untuk keharuman dan nutrisi kulit",
            "sold" => 150
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/SabunBatang.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "SBN-MND-1",
            "price" => 20000,
            "stock" => 100
        ]);

        $product = Product::create([
            "name" => "Sisir Rambut Kayu", 
            "slug" => "sisir-rambut-kayu", 
            "product_category_id" => 3, 
            "weight" => 40, 
            "material" => "Kayu cendana", 
            "process" => "Kayu alami dipilih dengan cermat untuk memastikan kualitas terbaik. Kayu dipotong sesuai ukuran dan dihaluskan untuk menciptakan permukaan yang lembut. Setelah itu, sisir dirakit tanpa bahan tambahan seperti lem kimia dan diberi lapisan minyak alami untuk meningkatkan daya tahan.", 
            "certification" => "FSC (Forest Stewardship Council)", 
            "description" => "Sisir rambut dari kayu alami yang ramah lingkungan, lembut di kulit kepala, dan membantu mengurangi rambut kusut. Desain ergonomis dan tahan lama.",
            "sold" => 20
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/SisirKayu.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "SSR-KYU-1",
            "price" => 40000,
            "stock" => 150
        ]);

        $product = Product::create([
            "name" => "Buku Catatan Daur Ulang", 
            "slug" => "buku-catatan-daur-ulang", 
            "product_category_id" => 1, 
            "weight" => 500, 
            "material" => "Kertas daur ulang, karton daur ulang untuk sampul, spiral kawat/benang daur ulang", 
            "process" => "Kertas bekas dikumpulkan dan dihancurkan menjadi pulp sebelum dicetak ulang menjadi lembaran kertas baru. Karton untuk sampul buku juga terbuat dari bahan daur ulang. Buku ini dirakit dan dijilid menggunakan metode yang menghindari penggunaan bahan berbahaya seperti lem plastik", 
            "certification" => "Ekolabel Indonesia", 
            "description" => "Buku catatan ramah lingkungan dengan kertas daur ulang berkualitas tinggi. Cocok untuk menulis, mencatat ide, atau membuat jurnal, mendukung gaya hidup berkelanjutan",
            "sold" => 350
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/BukuTulis.jpg"
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BKU-TLS-PTH",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Putih" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BKU-TLS-CKT",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Cokelat" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BKU-TLS-HJU",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Hijau" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BKU-TLS-BRU",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Biru Tua" 
        ]);

        $product = Product::create([
            "name" => "Tempat Pensil kain", 
            "slug" => "tempat-pensil-kain", 
            "product_category_id" => 1, 
            "weight" => 80, 
            "material" => "Kain kanvas, katun, atau denim, ritsleting", 
            "process" => "Kain seperti kanvas, katun, atau denim dipotong dan dijahit menjadi tempat pensil. Tidak ada pewarna sintetis yang digunakan untuk memastikan produk ini ramah lingkungan. Desain sederhana mendukung gaya hidup bebas plastik dengan memanfaatkan bahan yang tahan lama", 
            "certification" => "GOTS (Global Organic Textile Standard)", 
            "description" => "Tempat pensil multifungsi dari kain yang kuat dan tahan lama. Desain ringkas dan stylish, cocok untuk menyimpan alat tulis, kosmetik, atau barang-barang kecil lainnya",
            "sold" => 60
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/TempatPensil.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "TMT-PSL-1",
            "price" => 35000,
            "stock" => 75
        ]);

        $product = Product::create([
            "name" => "Sedotan Stainless Steel Set", 
            "slug" => "sedotan-stainless-steel-set", 
            "product_category_id" => 4, 
            "weight" => 100, 
            "material" => "Stainless steel food grade (SUS 304).", 
            "process" => "Stainless steel food-grade diproses melalui metode pemotongan presisi tinggi untuk membentuk sedotan. Setiap sedotan dipoles hingga halus dan disterilkan sebelum dikemas dalam pouch kain untuk memudahkan penggunaan ulang", 
            "certification" => "Ekolabel Indonesia", 
            "description" => "Sedotan stainless steel yang dapat digunakan berulang kali, alternatif ramah lingkungan untuk sedotan plastik sekali pakai. Aman untuk minuman dingin maupun panas, mudah dibersihkan dengan sikat yang tersedia",
            "sold" => 10
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/SedotanStainless.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "SDN-STL-1",
            "price" => 50000,
            "stock" => 50
        ]);

        $product = Product::create([
            "name" => "Spons Mandi Loofah Alami", 
            "slug" => "spons-mandi-loofah-alami", 
            "product_category_id" => 2, 
            "weight" => 40, 
            "material" => "Tanaman loofah kering", 
            "process" => "Tanaman loofah dipanen dan dikeringkan secara alami di bawah sinar matahari. Setelah kering, loofah dipotong menjadi ukuran yang sesuai untuk penggunaan mandi. Spons ini dikemas tanpa bahan tambahan untuk memastikan sepenuhnya biodegradable", 
            "certification" => "Ekolabel Indonesia", 
            "description" => "Spons mandi alami dari loofah, eksfoliator lembut untuk kulit. Biodegradable sepenuhnya, membantu mengangkat sel kulit mati dan melancarkan sirkulasi darah",
            "sold" => 40
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/SponsLoofah.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "SPS-LOH-1",
            "price" => 25000,
            "stock" => 50
        ]);

        $product = Product::create([
            "name" => "Kain Lap Dapur Bahan Bambu ", 
            "slug" => "kain-lap-dapur-bahan-bambu", 
            "product_category_id" => 2, 
            "weight" => 50, 
            "material" => "Serat bambu", 
            "process" => "Serat bambu diproses dengan metode mekanis untuk menjaga keaslian bahan. Kain ini ditenun menjadi lap yang ringan dan cepat kering. Proses ini tidak melibatkan bahan kimia agresif, menjadikan produk ini aman untuk lingkungan.", 
            "certification" => "Ekolabel Indonesia", 
            "description" => "Kain lap dapur super absorban terbuat dari serat bambu yang lembut dan cepat kering. Lebih higienis dan tahan lama dibandingkan kain biasa, serta ramah lingkungan",
            "sold" => 100
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/KainDapur.jpg"
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "KIN-DPR-PTH",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Putih" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "KIN-DPR-HJU",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Hijau Muda" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "KIN-DPR-ORN",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Orange" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "KIN-DPR-PNK",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Pink" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "KIN-DPR-CKT",
            "price" => 25000,
            "stock" => 50
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Cokelat" 
        ]);
        

        $product = Product::create([
            "name" => "Pengharum Ruangan Semprot Bahan Alami", 
            "slug" => "pengharum-ruangan-semprot-bahan-alami", 
            "product_category_id" => 5, 
            "weight" => 200, 
            "material" => "Air suling, alkohol biji-bijian, minyak esensial alami", 
            "process" => "Minyak esensial murni dicampur dengan air suling dan alkohol biji-bijian untuk menciptakan campuran pengharum yang alami. Campuran ini dikemas dalam botol kaca, menghindari penggunaan plastik sekali pakai dan menjamin keberlanjutan", 
            "certification" => "COSMOS Natural/Organic", 
            "description" => "Pengharum ruangan semprot yang terbuat dari bahan-bahan alami dan minyak esensial murni, bebas dari bahan kimia sintetis. Menciptakan suasana segar dan nyaman di rumah Anda secara alami",
            "sold" => 70
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/PengharumRuangan.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "HRM-RGN-100",
            "price" => 35000,
            "stock" => 50
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "HRM-RGN-200",
            "price" => 65000,
            "stock" => 150
        ]);

        $product = Product::create([
            "name" => "Sumpit Bambu", 
            "slug" => "sumpit-bambu", 
            "product_category_id" => 4, 
            "weight" => 30, 
            "material" => "bambu alami", 
            "process" => "Batang bambu dipotong dan dihaluskan menggunakan alat manual. Setelah selesai, sumpit dicuci, dikeringkan, dan dibiarkan tanpa lapisan pelindung sintetis untuk memastikan produk ini sepenuhnya biodegradable", 
            "certification" => "FSC (Forest Stewardship Council)", 
            "description" => "Sumpit bambu alami yang ringan dan ramah lingkungan. Permukaan halus dan mudah digenggam, cocok untuk menikmati berbagai hidangan Asia",
            "sold" => 160
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/SumpitBambu.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "SPT-BMB-1",
            "price" => 15000,
            "stock" => 75
        ]);

        $product = Product::create([
            "name" => "Pembungkus Makanan Beeswax (Beeswax Wrap)", 
            "slug" => "pembungkus-makanan-beeswax-beeswax-wrap", 
            "product_category_id" => 4, 
            "weight" => 200, 
            "material" => "Kain katun organik, beeswax (lilin lebah), resin pohon, minyak jojoba", 
            "process" => "Kain katun organik dipotong sesuai ukuran dan dilapisi dengan campuran beeswax, resin pohon, dan minyak alami. Campuran ini dilelehkan ke kain dengan pemanasan lembut. Produk akhir memiliki daya tahan dan dapat digunakan kembali, menggantikan plastik wrap", 
            "certification" => "GOTS (Global Organic Textile Standard)", 
            "description" => "Gantikan plastik wrap Anda dengan pembungkus makanan beeswax yang dapat digunakan berulang kali. Elastis dan tahan lama, menjaga kesegaran makanan seperti keju, roti, buah, atau sayuran. Cukup cuci dengan air dingin dan sabun ringan",
            "sold" => 50
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/BeeswaxWrap.jpg"
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BEE-ORN-1",
            "price" => 10000,
            "stock" => 1000
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Orange" 
        ]);

        Size::create([
            "product_variant_id" => $variant->id,
            "name" => "1 pcs" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BEE-ORN-5",
            "price" => 40000,
            "stock" => 1000
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Orange" 
        ]);

        Size::create([
            "product_variant_id" => $variant->id,
            "name" => "5 pcs" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BEE-HJU-5",
            "price" => 40000,
            "stock" => 1000
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Hijau" 
        ]);

        Size::create([
            "product_variant_id" => $variant->id,
            "name" => "5 pcs" 
        ]);

        $variant = ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BEE-HJU-1",
            "price" => 10000,
            "stock" => 1000
        ]);

        Color::create([
            "product_variant_id" => $variant->id,
            "name" => "Hijau" 
        ]);

        Size::create([
            "product_variant_id" => $variant->id,
            "name" => "1 pcs" 
        ]);

        $product = Product::create([
            "name" => "Bola Pengering Pakaian Wol", 
            "slug" => "bola-pengering Pakaian Wol", 
            "product_category_id" => 1, 
            "weight" => 40, 
            "material" => "100% wol domba alami", 
            "process" => "Wol domba alami dikumpulkan, dicuci, dan digulung menjadi bola. Proses ini dilakukan tanpa tambahan pewarna atau bahan sintetis. Bola wol ini diuji untuk memastikan daya tahan sebelum dikemas dalam kantong kain biodegradable", 
            "certification" => "Ekolabel Indonesia", 
            "description" => "Bola pengering pakaian wol ini membantu mengurangi waktu pengeringan di mesin, menghemat energi, dan melunakkan pakaian secara alami tanpa bahan kimia. Alternatif ramah lingkungan untuk pelembut pakaian cair atau lembaran pengering, serta dapat digunakan ratusan kali",
            "sold" => 25
        ]);

        ProductImage::create([
            "product_id" => $product->id,
            "image" => "products/PengeringWol.jpg"
        ]);

        ProductVariant::create([
            "product_id" => $product->id,
            "sku" => "BLA-WOL-1",
            "price" => 70000,
            "stock" => 100
        ]);
    }
}
