<?php
function menuSidebar()
{
    $group_code = Auth::user()->group->code ?? null;
    $menus = [
        'ADM' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fa-solid fa-house'
            ],
            'setting' => [
                'name' => 'Pengaturan',
                'icon' => 'fa-solid fa-gear',
                'childs' => [
                    'users' => [
                        'name' => 'Daftar Pengguna',
                        'icon' => 'fa-solid fa-users'
                    ]
                ]
            ],
            'report_data' => [
                'name' => 'Laporan Pendataan',
                'icon' => 'fa-solid fa-chart-simple'
            ]
        ],
        'SPV' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fa-solid fa-house'
            ],
            'collection_data' => [
                'name' => 'Data Pendataan',
                'icon' => 'fa-solid fa-file-pen'
            ],
            'election_results' => [
                'name' => 'Data Hasil Pemilu',
                'icon' => 'fa-solid fa-clipboard-list'
            ],
            'report_data' => [
                'name' => 'Laporan Pendataan',
                'icon' => 'fa-solid fa-chart-simple'
            ],
            'report_result' => [
                'name' => 'Laporan Hasil Pemilu',
                'icon' => 'fa-solid fa-chart-simple'
            ]
        ],
        'EMP' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fa-solid fa-house'
            ],
            'election_results' => [
                'name' => 'Data Hasil Pemilu',
                'icon' => 'fa-solid fa-clipboard-list'
            ]
        ]
    ];
    return ($menus[$group_code] ?? []);
}

function scoreOptions()
{
    // 1 holland & 2 IST
    $options = [
        1=>[0,1,2,3],
        2=>[0,1]
    ];

    return $options;
}

function getOptions($type)
{
    $options = scoreOptions()[$type];

    return $options;
}

function monthsIndo()
{
    return array(
        1 => "Januari",
        2 => "Februari",
        3 => "Maret",
        4 => "April",
        5 => "Mei",
        6 => "Juni",
        7 => "Juli",
        8 => "Agustus",
        9 => "September",
        10 => "Oktober",
        11 => "November",
        12 => "Desember",
    );
}

function DateToIndo($date)
{
    if ($date && date('Y', strtotime($date)) > 1) {
        $BulanIndo = monthsIndo();

        $tahun = date('Y', strtotime($date));
        $bulan = date('n', strtotime($date));
        $tgl = date('d', strtotime($date));

        $result = $tgl . " " . $BulanIndo[(int) $bulan] . " " . $tahun;
    } else {
        $result = null;
    }

    return ($result);
}

function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}

function weekOfYear($date) {
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    }
    else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    }
    else {
        // It's a "normal" week.
        return $weekOfYear;
    }
}

function status() {
    $status = [
        1 => 'Belum Fixed',
        2 => 'Fixed',
        // 1 => 'Belum diverifikasi',
        // 2 => 'Sudah diverifikasi',
        // 3 => 'Tidak Terdaftar DPT',
        // 4 => 'Luar DPT'
    ];

    return $status;
}

function statusColor() {
    $status = [
        1 => 'secondary',
        2 => 'primary',
        3 => 'danger',
        4 => 'warning'
    ];

    return $status;
}

function status_share() {
    $status = [
        1 => 'Belum dibagikan',
        2 => 'Sudah dibagikan'
    ];

    return $status;
}

function status_shareColor() {
    $status = [
        1 => 'secondary',
        2 => 'success'
    ];

    return $status;
}

function status_share_fixed() {
    $status = [
        'NO' => 'No',
        'C1' => 'C1',
        'C2' => 'C2',
        'C3' => 'C3'
    ];

    return $status;
}

function status_share_fixedColor() {
    $status = [
        'NO' => 'danger',
        'C1' => 'success',
        'C2' => 'primary',
        'C3' => 'purple'
    ];

    return $status;
}

function orders() {
    $orders = [
        1 => 'asc',
        2 => 'desc'
    ];

    return $orders;
}

function getStatusAdd() {
    $total_target = \Models\subdistrict::select('target')
                ->sum('target');
    $total_data = \Models\collection_data::select('id')
                ->count();
                
    return $total_target <= $total_data;
}

function getFirstChar($word) {
    $words = explode(" ", $word);
                    
    return $words[0] ?? null;
}