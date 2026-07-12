<?php
// app/Http/Controllers/Patient/SettingController.php
// BARU: Controller untuk halaman Pengaturan modul pasien

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /* ---------------------------------------------------------------- INDEX */
    public function index()
    {
        // Ambil semua setting sebagai key-value array
        $settings = Setting::pluck('setting_value', 'setting_key');

        // Default jika key belum ada di DB
        $defaults = [
            'rm_mode'      => 'manual',
            'rm_prefix'    => 'RM',
            'visit_prefix' => 'VST',
            'per_page'     => '10',
            'date_format'  => 'd-m-Y',
            // setting klinik yang sudah ada
            'hospital_name'    => 'SIM Klinik',
            'hospital_phone'   => '',
            'hospital_email'   => '',
            'hospital_address' => '',
            'default_payment'  => 'Umum',
        ];

        $settings = array_merge($defaults, $settings->toArray());

        return view('patient.setting.index', compact('settings'));
    }

    /* ---------------------------------------------------------------- UPDATE */
    public function update(Request $request)
    {
        $request->validate([
            'rm_mode'       => 'required|in:manual,auto',
            'rm_prefix'     => 'required|string|max:10',
            'visit_prefix'  => 'required|string|max:10',
            'per_page'      => 'required|integer|min:5|max:100',
            'date_format'   => 'required|in:d-m-Y,Y-m-d,m/d/Y',
            'hospital_name' => 'nullable|string|max:150',
            'hospital_phone'=> 'nullable|string|max:20',
            'hospital_email'=> 'nullable|email|max:100',
            'hospital_address' => 'nullable|string',
            'default_payment'  => 'required|in:Umum,BPJS,Asuransi',
        ]);

        $keys = [
            'rm_mode', 'rm_prefix', 'visit_prefix', 'per_page', 'date_format',
            'hospital_name', 'hospital_phone', 'hospital_email', 'hospital_address',
            'default_payment',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(
                    ['setting_key'   => $key],
                    ['setting_value' => $request->input($key)]
                );
            }
        }

        return redirect()
            ->route('patient.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
