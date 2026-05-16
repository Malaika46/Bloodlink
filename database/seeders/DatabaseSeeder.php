<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Donor;
use App\Models\EmergencyRequest;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo donor users
        $donors = [
            ['first_name'=>'Ahmed',   'last_name'=>'Khan',    'email'=>'ahmed@demo.com',   'blood_type'=>'O+', 'city'=>'Lahore',    'phone'=>'03001234567'],
            ['first_name'=>'Fatima',  'last_name'=>'Zahra',   'email'=>'fatima@demo.com',  'blood_type'=>'A+', 'city'=>'Karachi',   'phone'=>'03119876543'],
            ['first_name'=>'Bilal',   'last_name'=>'Hussain', 'email'=>'bilal@demo.com',   'blood_type'=>'B+', 'city'=>'Islamabad', 'phone'=>'03335556677'],
            ['first_name'=>'Ayesha',  'last_name'=>'Siddiqui','email'=>'ayesha@demo.com',  'blood_type'=>'AB+','city'=>'Lahore',    'phone'=>'03214441122'],
            ['first_name'=>'Usman',   'last_name'=>'Ghani',   'email'=>'usman@demo.com',   'blood_type'=>'O-', 'city'=>'Rawalpindi','phone'=>'03457778899'],
            ['first_name'=>'Zara',    'last_name'=>'Tariq',   'email'=>'zara@demo.com',    'blood_type'=>'B-', 'city'=>'Faisalabad','phone'=>'03126665544'],
            ['first_name'=>'Hassan',  'last_name'=>'Raza',    'email'=>'hassan@demo.com',  'blood_type'=>'A-', 'city'=>'Multan',    'phone'=>'03009988776'],
            ['first_name'=>'Nimra',   'last_name'=>'Iqbal',   'email'=>'nimra@demo.com',   'blood_type'=>'AB-','city'=>'Karachi',   'phone'=>'03331122334'],
        ];

        foreach ($donors as $i => $d) {
            $user = User::create([
                'first_name'      => $d['first_name'],
                'last_name'       => $d['last_name'],
                'name'            => $d['first_name'].' '.$d['last_name'],
                'email'           => $d['email'],
                'password'        => Hash::make('password'),
                'blood_type'      => $d['blood_type'],
                'city'            => $d['city'],
                'phone'           => $d['phone'],
                'is_available'    => true,
                'donations_count' => rand(1, 15),
            ]);

            Donor::create([
                'user_id'         => $user->id,
                'blood_type'      => $d['blood_type'],
                'city'            => $d['city'],
                'phone'           => $d['phone'],
                'is_available'    => true,
                'donations_count' => $user->donations_count,
            ]);
        }

        // Demo emergency requests
        EmergencyRequest::create(['patient_name'=>'Shahid Mehmood','age'=>45,'blood_type'=>'O-','units'=>2,'urgency'=>'critical','hospital_name'=>'Services Hospital','city'=>'Lahore','contact_name'=>'Asif Mehmood','phone'=>'03005556789','notes'=>'Emergency surgery patient. Needs blood urgently.','status'=>'pending']);
        EmergencyRequest::create(['patient_name'=>'Rehana Begum','age'=>32,'blood_type'=>'B+','units'=>1,'urgency'=>'urgent','hospital_name'=>'Aga Khan Hospital','city'=>'Karachi','contact_name'=>'Tariq Begum','phone'=>'03112223344','notes'=>'Thalassemia patient.','status'=>'pending']);
        EmergencyRequest::create(['patient_name'=>'Ali Raza','age'=>28,'blood_type'=>'A+','units'=>3,'urgency'=>'critical','hospital_name'=>'PIMS Hospital','city'=>'Islamabad','contact_name'=>'Sara Ali','phone'=>'03338887766','notes'=>'Road accident victim.','status'=>'pending']);
    }
}
