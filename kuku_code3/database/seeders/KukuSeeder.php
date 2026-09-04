<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KondisiKuku;

class KukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data untuk 7 kelas kondisi kuku
        $kondisiKukus = [
            [
                'name' => 'Kuku_Sehat',
                'display_name' => 'Kuku tampak Sehat',
                'description' => 'Kuku dalam kondisi sehat umumnya berwarna merah muda, permukaannya halus, tidak rapuh, dan tidak mengalami perubahan bentuk atau warna yang mencolok. Kondisi ini menandakan sirkulasi darah dan pertumbuhan kuku yang normal.'
            ],
            [
                'name' => 'Garis_Gelap',
                'display_name' => 'Kuku Berwarna Gelap/Terdapat Garis Gelap pada Kuku',
                'description' => 'Garis gelap pada kuku muncul sebagai garis atau bercak berwarna cokelat hingga hitam. Penyebabnya bisa beragam, mulai dari cedera ringan, perubahan pigmen, hingga kondisi medis tertentu. Jika garis gelap muncul secara tiba-tiba atau semakin melebar, disarankan untuk melakukan pemeriksaan lebih lanjut.'
            ],
            [
                'name' => 'Kuku_Membiru',
                'display_name' => 'Kuku Berwarna Kebiruan',
                'description' => 'Kuku membiru menunjukkan perubahan warna kuku menjadi kebiruan atau keunguan. Hal ini umumnya berkaitan dengan kurangnya pasokan oksigen dalam darah atau gangguan sirkulasi. Kondisi ini sebaiknya diperhatikan, terutama jika disertai gejala lain seperti sesak napas.'
            ],
            [
                'name' => 'Clubbing',
                'display_name' => 'Kuku Menebal dan Membulat (Clubbing)',
                'description' => 'Kondisi ini merupakan kondisi di mana ujung jari dan kuku tampak membulat dan membesar secara tidak normal. Perubahan ini terjadi secara perlahan dan dapat berkaitan dengan gangguan pernapasan, jantung, atau kondisi kesehatan lainnya yang memengaruhi aliran oksigen dalam tubuh.'
            ],
            [
                'name' =>'Onychogryphosis',
                'display_name' => 'Penebalan Kuku Abnormal/Kuku terlepas dari Kulit',
                'description' => 'Kondisi ini merupakan kondisi di mana kuku mengalami penebalan berlebihan, tumbuh tidak beraturan, dan tampak melengkung. Kondisi ini sering dialami oleh lansia atau akibat tekanan dan perawatan kuku yang kurang tepat dalam jangka panjang.'
            ],
            [
                'name' => 'Pitting',
                'display_name' => 'Kuku Berlubang Kecil/Permukaan kuku tidak rata',
                'description' => 'Kondisi kuku ini ditandai dengan adanya lekukan kecil seperti titik-titik pada permukaan kuku/permukaan kuku tidak rata. Kondisi ini sering dikaitkan dengan gangguan pada pertumbuhan kuku dan dapat berhubungan dengan masalah kulit tertentu. Namun, pitting ringan juga bisa muncul tanpa disertai penyakit serius.'
            ],
            [
                'name' => 'Kuku_Putih',
                'display_name' => 'Kuku Berwarna Putih/Tampak Pucat',
                'description' => 'Kuku putih ditandai dengan perubahan warna kuku menjadi pucat atau putih. Kondisi ini dapat disebabkan oleh berbagai faktor, seperti kekurangan nutrisi, infeksi jamur, atau gangguan kesehatan tertentu. Tidak semua kuku putih menandakan penyakit serius, namun perlu diperhatikan jika terjadi secara terus-menerus.'
            ],
            [
                'name' => 'Bukan_Kuku_Manusia',
                'display_name' => 'Bukan Gambar Kuku/Bukan Kuku Manusia',
                'description' => 'Gambar yang diunggah bukan merupakan kuku. Pastikan gambar yang diunggah adalah kuku manusia karena sistem hanya dapat menganalisis gambar kuku manusia.'
            ],
        ];

        // Masukkan data ke tabel dan tambahkan relasinya
        foreach ($kondisiKukus as $kondisiData) {
            $kondisiKuku = KondisiKuku::create([
                'name' => $kondisiData['name'],
                'display_name' => $kondisiData['display_name'],
                'description' => $kondisiData['description'],
            ]);

            // Isi tabel related_diseases dan care_recommendations
            switch ($kondisiData['name']) {
                case 'Kuku_Sehat':
                    $kondisiKuku->penyakits()->create(['penyakit_name' => 'Tidak ada penyakit khusus', 'description' => 'Kondisi kuku normal dan sehat.']);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => 'Pertahankan kebersihan kuku dan lakukan perawatan rutin.']);
                    break;
                case 'Garis_Gelap':
                    $kondisiKuku->penyakits()->create(['penyakit_name' => 'Kemungkinan Melanoma Subungual', 'description' => 'Dalam beberapa kasus, garis gelap pada kuku dapat berhubungan dengan melanoma subungual. Namun, kondisi ini memerlukan pemeriksaan medis lanjutan.']);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => 'Segera konsultasikan dengan dokter atau dermatologis untuk diagnosis lebih lanjut. Jangan mencoba mengobati sendiri.']);
                    break;
                case 'Kuku_Membiru':
                    $kondisiKuku->penyakits()->createMany([
                        ['penyakit_name' => 'Dapat berkaitan dengan Penyakit Paru-paru', 'description' => 'Seperti PPOK, yang menyebabkan kekurangan oksigen.'],
                        ['penyakit_name' => 'Dapat berkaitan dengan Penyakit Jantung', 'description' => 'Penyakit jantung kongenital atau kondisi lain yang mengurangi sirkulasi darah.']
                    ]);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => 'Segera lakukan pemeriksaan medis jika disertai gejala lain seperti sesak napas.']);
                    break;
                case 'Clubbing':
                    $kondisiKuku->penyakits()->createMany([
                        ['penyakit_name' => 'Dapat berkaitan dengan Penyakit Paru-paru Kronis', 'description' => 'Seperti fibrosis kistik, yang mempengaruhi penyerapan oksigen.'],
                        ['penyakit_name' => 'Dapat berkaitan dengan Penyakit Jantung Kongenital', 'description' => 'Masalah jantung sejak lahir yang menyebabkan sirkulasi darah tidak efisien.']
                    ]);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => 'Segera konsultasikan dengan dokter untuk evaluasi kondisi paru-paru atau jantung.']);
                    break;
                case 'Onychogryphosis':
                    $kondisiKuku->penyakits()->create(['penyakit_name' => 'Disebabkan oleh trauma atau kurangnya perawatan kuku jangka panjang', 'description' => 'Biasanya disebabkan oleh trauma atau kurangnya perawatan kuku jangka panjang.']);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => 'Lakukan perawatan kuku secara rutin dan konsultasikan dengan tenaga medis bila diperlukan.']);
                    break;
                case 'Pitting':
                    $kondisiKuku->penyakits()->createMany([
                        ['penyakit_name' => 'Dapat berkaitan dengan kondisi Psoriasis', 'description' => 'Penyakit autoimun yang menyebabkan kulit bersisik dan dapat memengaruhi kuku.'],
                        ['penyakit_name' => 'Dapat berkaitan dengan Kondisi Alopecia Areata', 'description' => 'Kondisi autoimun yang menyebabkan rambut rontok dan dapat memengaruhi kuku.']
                    ]);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => 'Gunakan pelembap kuku secara rutin dan hindari trauma pada kuku. Konsultasikan dengan dermatologis.']);
                    break;
                case 'Kuku_Putih':
                    $kondisiKuku->penyakits()->createMany([
                        ['penyakit_name' => 'Dapat berkaitan dengan Penyakit Ginjal', 'description' => 'Kadang-kadang dikaitkan dengan kondisi ginjal kronis.'],
                        ['penyakit_name' => 'Dapat berkaitan dengan Penyakit Hati', 'description' => 'Seperti sirosis hati, yang dapat memengaruhi warna kuku.']
                    ]);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => 'Konsultasikan dengan dokter untuk mencari tahu penyebab mendasar dan mendapatkan perawatan yang tepat.']);
                    break;
                case 'Bukan_Kuku_Manusia':
                    $kondisiKuku->penyakits()->create(['penyakit_name' => '-', 'description' => '-']);
                    $kondisiKuku->rekomendasiPerawatans()->create(['recommendation' => '-']);
                    break;
            }
        }
    }
}
