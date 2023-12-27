<?php

use App\Helpers\MenuBuilder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

if (!function_exists('lookup')) {
    /**
     * Get the lookup value from table by lookup code.
     * 
     * @param string|null $code
     * @param mixed|null $default
     * @return mixed
     */
    function lookup(string $code = null, $default = null)
    {
        if ($code === null) {
            return Config::get('lookup') ?? [];
        }
        return Config::get("lookup.$code.value", $default);
    }
}

if (!function_exists('lookup_type')) {
    /**
     * Get the lookup type from table by lookup code.
     * 
     * @param string|null $code
     * @param mixed|null $default
     * @return mixed
     */
    function lookup_type(string $code = null, $default = null)
    {
        if ($code === null) {
            return Config::get('lookup') ?? [];
        }
        return Config::get("lookup.$code.type", $default);
    }
}

if (!function_exists('filter_navigation')) {
    /**
     * Get the filtered Navigation for sidebar and top navigation bar
     * 
     * @param string $type
     * @return array
     */
    function filter_navigation(string $type = 'main')
    {
        if (Lang::locale() == 'id') {
            $menus = Config::get("erp-id.menu.$type");
            return (new MenuBuilder($menus, config('erp-id.filter_classes')))->getFiltered();
        } else {
            $menus = Config::get("erp-en.menu.$type");
            return (new MenuBuilder($menus, config('erp-en.filter_classes')))->getFiltered();
        }
    }
}

if (!function_exists('to_int')) {
    /**
     * Filter string and return integers contained in the given string
     * 
     * @param string $string
     * @return int
     */
    function to_int(string $string = null)
    {
        if (strlen(preg_replace('/[^0-9]/', '', $string)) > 0) {
            return (int) preg_replace('/[^0-9]/', '', $string);
        }
        return 0;
    }
}

if (!function_exists('terbilang')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }
}

if (!function_exists('monthNames')) {
    /**
     * Get month names
     * 
     * @return array
     */
    function monthNames()
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
    }
}

if (!function_exists('whatsapp')) {
    /**
     * Create new WhatsApp instance
     * 
     * @return \App\Helpers\WhatsApp
     */
    function whatsapp()
    {
        return app('whatsapp');
    }
}