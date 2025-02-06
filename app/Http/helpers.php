<?php
function menuSidebar()
{
    $group_code = Auth::user()->group->code ?? null;
    $menus = [
        'ADM' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fas fa-home'
            ],
            'setting' => [
                'name' => 'Pengaturan',
                'icon' => 'fas fa-cog',
                'childs' => [
                    'users' => [
                        'name' => 'Users',
                        'icon' => 'fas fa-users'
                    ]
                ]
            ],
            'employee' => [
                'name' => 'Employee',
                'icon' => 'fas fa-users'
            ]
        ],
        'SPV' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fas fa-home'
            ],
            'task' => [
                'name' => 'List Job',
                'icon' => 'fas fa-briefcase'
            ],
            'report' => [
                'name' => 'Report Job',
                'icon' => 'fas fa-chart-bar'
            ]
        ],
        'EMP' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fas fa-home'
            ],
            'task' => [
                'name' => 'List Job',
                'icon' => 'fas fa-briefcase'
            ],
            'report' => [
                'name' => 'Report Job',
                'icon' => 'fas fa-chart-bar'
            ]
        ]
    ];
    return ($menus[$group_code] ?? []);
}

function allMenuSidebar()
{
    $group_code = Auth::user()->group->code ?? null;
    $menus = [
        'ADM' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fas fa-home'
            ],
            'setting' => [
                'name' => 'Pengaturan',
                'icon' => 'fas fa-cog',
            ],
            'employee' => [
                'name' => 'Employee',
                'icon' => 'fas fa-users'
            ],
            'users' => [
                'name' => 'Users',
                'icon' => 'fas fa-users'
            ]
        ],
        'SPV' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fas fa-home'
            ],
            'task' => [
                'name' => 'List Job',
                'icon' => 'fas fa-briefcase'
            ],
            'report' => [
                'name' => 'Report Job',
                'icon' => 'fas fa-briefcase'
            ]
        ],
        'EMP' => [
            'home' => [
                'name' => 'Home',
                'icon' => 'fas fa-house'
            ],
            'task' => [
                'name' => 'List Job',
                'icon' => 'fas fa-briefcase'
            ],
            'report' => [
                'name' => 'Report Job',
                'icon' => 'fas fa-briefcase'
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
        1 => 'Active',
        0 => 'Non Active'
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

function timeOfDay($date = null){
    $strtotime = strtotime($date ?? date('Y-m-d H:i:s'));

    $time = date("H", $strtotime);
    $timezone = date("e", $strtotime);

    if ($time < "12") {
        $day = "Good Morning";
    } elseif ($time >= "12" && $time < "17") {
        $day = "Good Afternoon";
    } elseif ($time >= "17" && $time < "19") {
        $day = "Good Evening";
    } else {
        $day = "Good Night";
    }

    return $day;
}

function getInitials($name) {
    $words = explode(" ", $name);
    $initials = "";
    foreach ($words as $word) {
        $initials .= $word[0];
    }
    
    $initials = substr($initials, 0, 2);
    return $initials;
}

function getFirstName($name){
    $name = explode(' ', $name);

    $firstName = $name[0] ?? null;
    return $firstName;
}

function statusBg() {
    $status = [
        1 => 'success',
        0 => 'danger'
    ];

    return $status;
}