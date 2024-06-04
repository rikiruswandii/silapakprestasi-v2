<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Settings extends Seeder
{
    private $tableName = 'settings';
    private $tableRecords = [
        [
            'code' => 'app_name',
            'content' => 'Silapak Prestasi'
        ],
        [
            'code' => 'app_title',
            'content' => 'Sistem Informasi Pelayanan Pro Aktif Promosi Investasi dan Inovasi Pelayanan Publik'
        ],
        [
            'code' => 'app_description',
            // phpcs:ignore
            'content' => 'Silapak Prestasi adalah sistem informasi untuk meningkatkan layanan promosi investasi dan inovasi pelayanan publik dari Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Purwakarta.'
        ],
        [
            'code' => 'app_keywords',
            // phpcs:ignore
            'content' => 'silapak prestasi, pelayanan pro aktif promosi investasi, pelayanan publik, peta potensi dan peluang investasi, promosi investasi, profil layanan instansi, promosi investasi pelayanan publik, kabupaten purwakarta, purwakarta kab, dinas penanaman modal dan pelayanan terpadu satu pintu, dpmptsp'
        ],
        [
            'code' => 'app_holder',
            'content' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu'
        ],
        [
            'code' => 'app_header',
            'content' => 'Tingkatkan Minat dan Realisasi Investasi'
        ],
        [
            'code' => 'app_tagline',
            // phpcs:ignore
            'content' => 'Dapatkan informasi potensi dan peluang investasi dan informasi inovasi pelayanan publik di Kabupaten Purwakarta.'
        ],
        [
            'code' => 'app_about',
            // phpcs:ignore
            'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in urna vel eros posuere accumsan ultricies quis leo. Proin iaculis mi sem, tempus malesuada odio elementum non. Pellentesque at leo in lorem pretium tincidunt. Morbi euismod mauris eu lorem porttitor, id dapibus nisl tempor. Maecenas ut ex vestibulum, porttitor nunc et, vulputate elit. Suspendisse sed odio sodales, efficitur mi eu, consequat mauris. Pellentesque malesuada lorem in ligula aliquam accumsan. Aenean posuere odio vehicula eleifend tempus. Maecenas hendrerit risus sit amet tortor pellentesque interdum. Quisque aliquam quam ipsum, in interdum dolor porttitor sed. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur molestie lorem in pulvinar blandit. Nam faucibus gravida porta.</p><p>Donec nec diam dictum, bibendum eros quis, aliquam ante. Ut commodo velit varius neque faucibus ullamcorper. Sed convallis ipsum eu scelerisque cursus. Ut egestas suscipit erat vel imperdiet. Sed finibus sagittis orci, nec suscipit urna imperdiet sed. Vivamus vitae iaculis elit, sit amet blandit nibh. Praesent pellentesque convallis erat, eu pretium lectus molestie quis. Ut sagittis libero nec felis scelerisque porttitor. Proin venenatis ornare mi eget vulputate. Sed congue tortor imperdiet lectus auctor, vitae convallis mi fringilla. Suspendisse et urna sollicitudin, rutrum turpis a, rhoncus eros. In semper cursus tortor, suscipit mollis tortor fermentum a. Curabitur sed pulvinar diam, quis maximus neque. Donec vitae eros eget ex tincidunt pulvinar. Proin luctus eros nibh, sit amet pretium tellus accumsan et. Curabitur venenatis sodales libero, non porta lectus rhoncus a.</p><p>Vestibulum molestie quam ut tellus vehicula fringilla. Aliquam nisi tellus, sagittis eget lectus non, maximus scelerisque odio. Sed consectetur velit quis erat vehicula tempor. Vivamus tincidunt semper massa at accumsan. Donec tempor dolor vitae eros consectetur, vitae viverra diam interdum. Suspendisse urna mi, porta a rhoncus aliquam, pellentesque eu turpis. Nullam volutpat aliquet lacus, quis gravida erat efficitur ut. Aliquam mollis faucibus eros eu tincidunt.</p><p>Curabitur blandit eros eget ligula dignissim luctus. Donec tristique est nisi, et mollis eros malesuada sollicitudin. Nam fermentum ultricies cursus. Duis ante leo, tincidunt at neque eu, consectetur sollicitudin nisi. Nulla non augue tellus. Nullam id enim nibh. Nullam id metus ac sapien varius dapibus.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porta, leo vel gravida faucibus, lorem enim pulvinar magna, in scelerisque nibh ipsum vitae justo. Donec et ante tempor, ornare augue vitae, laoreet orci. Donec ac est vitae elit gravida interdum quis quis justo. Integer in dapibus sem, ut consequat magna. Etiam congue diam convallis, ultrices erat et, pretium quam. Fusce nisl dolor, tempor et bibendum vel, convallis non nisl. Phasellus consectetur arcu sit amet lacinia dapibus. Sed pellentesque, arcu vitae cursus viverra, quam purus imperdiet nisl, vitae malesuada lectus nibh eu velit. Praesent viverra sapien posuere, consectetur sem non, lobortis ante.</p>'
        ],
        [
            'code' => 'contact_address',
            'content' => 'Jl. Veteran No. 139, Nagri Kaler, Kec. Purwakarta, Kabupaten Purwakarta, Jawa Barat 41115'
        ],
        [
            'code' => 'contact_email',
            'content' => 'dpmptsp@purwakartakab.go.id'
        ],
        [
            'code' => 'contact_phone',
            'content' => '0264-8224794'
        ],
        [
            'code' => 'app_prefix',
            'content' => 'panel'
        ],
        [
            'code' => 'app_apikey',
            'content' => 'kucingKeren22'
        ],
        [
            'code' => 'app_maintenance',
            'content' => 'false'
        ],
        [
            'code' => 'cusdis_host',
            'content' => 'https://purwakarta-cusdis.vercel.app'
        ],
        [
            'code' => 'cusdis_id',
            'content' => 'da931065-f551-4e0e-b3cb-d8e5a8303b66'
        ]
    ];

    public function run()
    {
        // disable foreign key checks
        // prevent error foreign key
        $this->db->disableForeignKeyChecks();

        // insert data (multiple) into table
        $this->db->table($this->tableName)->insertBatch($this->tableRecords);

        // enable again foreign key checks
        $this->db->enableForeignKeyChecks();
    }
}
