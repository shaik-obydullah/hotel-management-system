<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\GuestPreference;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    protected array $guests = [
        ['name' => 'Oliver Bennett', 'email' => 'oliver.bennett@example.com', 'phone' => '+1 202 555 0111', 'nationality' => 'United States', 'city' => 'New York'],
        ['name' => 'Sophie Laurent', 'email' => 'sophie.laurent@example.com', 'phone' => '+33 1 45 67 89 01', 'nationality' => 'France', 'city' => 'Paris'],
        ['name' => 'Liam O’Connor', 'email' => 'liam.oconnor@example.com', 'phone' => '+353 87 555 0122', 'nationality' => 'Ireland', 'city' => 'Dublin'],
        ['name' => 'Aisha Rahman', 'email' => 'aisha.rahman@example.com', 'phone' => '+971 50 555 0133', 'nationality' => 'United Arab Emirates', 'city' => 'Dubai'],
        ['name' => 'Yuki Tanaka', 'email' => 'yuki.tanaka@example.com', 'phone' => '+81 3 5555 0144', 'nationality' => 'Japan', 'city' => 'Tokyo'],
        ['name' => 'Mateo García', 'email' => 'mateo.garcia@example.com', 'phone' => '+34 91 555 0155', 'nationality' => 'Spain', 'city' => 'Madrid'],
        ['name' => 'Amelia Fischer', 'email' => 'amelia.fischer@example.com', 'phone' => '+49 30 555 0166', 'nationality' => 'Germany', 'city' => 'Berlin'],
        ['name' => 'Noah Kim', 'email' => 'noah.kim@example.com', 'phone' => '+82 2 555 0177', 'nationality' => 'South Korea', 'city' => 'Seoul'],
        ['name' => 'Isabella Rossi', 'email' => 'isabella.rossi@example.com', 'phone' => '+39 06 555 0188', 'nationality' => 'Italy', 'city' => 'Rome'],
        ['name' => 'Ethan Williams', 'email' => 'ethan.williams@example.com', 'phone' => '+44 20 5555 0199', 'nationality' => 'United Kingdom', 'city' => 'London'],
        ['name' => 'Chloe Nguyen', 'email' => 'chloe.nguyen@example.com', 'phone' => '+84 90 555 0200', 'nationality' => 'Vietnam', 'city' => 'Ho Chi Minh City'],
        ['name' => 'Rajan Patel', 'email' => 'rajan.patel@example.com', 'phone' => '+91 22 5555 0211', 'nationality' => 'India', 'city' => 'Mumbai'],
        ['name' => 'Fatima Al-Sayed', 'email' => 'fatima.alsayed@example.com', 'phone' => '+974 33 555 0222', 'nationality' => 'Qatar', 'city' => 'Doha'],
        ['name' => 'Lucas Meyer', 'email' => 'lucas.meyer@example.com', 'phone' => '+41 44 555 0233', 'nationality' => 'Switzerland', 'city' => 'Zurich'],
        ['name' => 'Emma Johansson', 'email' => 'emma.johansson@example.com', 'phone' => '+46 8 555 0244', 'nationality' => 'Sweden', 'city' => 'Stockholm'],
        ['name' => 'Daniel Silva', 'email' => 'daniel.silva@example.com', 'phone' => '+351 21 555 0255', 'nationality' => 'Portugal', 'city' => 'Lisbon'],
        ['name' => 'Hana Kimura', 'email' => 'hana.kimura@example.com', 'phone' => '+81 6 5555 0266', 'nationality' => 'Japan', 'city' => 'Osaka'],
        ['name' => 'Omar Haddad', 'email' => 'omar.haddad@example.com', 'phone' => '+962 79 555 0277', 'nationality' => 'Jordan', 'city' => 'Amman'],
        ['name' => 'Grace Chen', 'email' => 'grace.chen@example.com', 'phone' => '+65 6555 0288', 'nationality' => 'Singapore', 'city' => 'Singapore'],
        ['name' => 'Victor Ivanov', 'email' => 'victor.ivanov@example.com', 'phone' => '+7 495 555 0299', 'nationality' => 'Russia', 'city' => 'Moscow'],
        ['name' => 'Mia Andersen', 'email' => 'mia.andersen@example.com', 'phone' => '+45 33 555 0300', 'nationality' => 'Denmark', 'city' => 'Copenhagen'],
        ['name' => 'Jorge Morales', 'email' => 'jorge.morales@example.com', 'phone' => '+52 55 5555 0311', 'nationality' => 'Mexico', 'city' => 'Mexico City'],
        ['name' => 'Sara Ali', 'email' => 'sara.ali@example.com', 'phone' => '+20 2 5555 0322', 'nationality' => 'Egypt', 'city' => 'Cairo'],
        ['name' => 'James Walker', 'email' => 'james.walker@example.com', 'phone' => '+61 2 5555 0333', 'nationality' => 'Australia', 'city' => 'Sydney'],
        ['name' => 'Lina Haddad', 'email' => 'lina.haddad@example.com', 'phone' => '+961 3 555 0344', 'nationality' => 'Lebanon', 'city' => 'Beirut'],
        ['name' => 'David Okafor', 'email' => 'david.okafor@example.com', 'phone' => '+234 1 555 0355', 'nationality' => 'Nigeria', 'city' => 'Lagos'],
        ['name' => 'Elena Petrova', 'email' => 'elena.petrova@example.com', 'phone' => '+7 812 555 0366', 'nationality' => 'Russia', 'city' => 'Saint Petersburg'],
        ['name' => 'Markus Weber', 'email' => 'markus.weber@example.com', 'phone' => '+43 1 555 0377', 'nationality' => 'Austria', 'city' => 'Vienna'],
        ['name' => 'Anna Kowalska', 'email' => 'anna.kowalska@example.com', 'phone' => '+48 22 555 0388', 'nationality' => 'Poland', 'city' => 'Warsaw'],
        ['name' => 'Theo Dubois', 'email' => 'theo.dubois@example.com', 'phone' => '+32 2 555 0399', 'nationality' => 'Belgium', 'city' => 'Brussels'],
        ['name' => 'Zara Ahmed', 'email' => 'zara.ahmed@example.com', 'phone' => '+92 51 555 0400', 'nationality' => 'Pakistan', 'city' => 'Islamabad'],
        ['name' => 'Benjamin Cohen', 'email' => 'benjamin.cohen@example.com', 'phone' => '+972 3 555 0411', 'nationality' => 'Israel', 'city' => 'Tel Aviv'],
        ['name' => 'Layla Hassan', 'email' => 'layla.hassan@example.com', 'phone' => '+216 71 555 0422', 'nationality' => 'Tunisia', 'city' => 'Tunis'],
        ['name' => 'Nikolai Smirnov', 'email' => 'nikolai.smirnov@example.com', 'phone' => '+7 343 555 0433', 'nationality' => 'Russia', 'city' => 'Yekaterinburg'],
        ['name' => 'Emily Roberts', 'email' => 'emily.roberts@example.com', 'phone' => '+1 415 555 0444', 'nationality' => 'United States', 'city' => 'San Francisco'],
        ['name' => 'Ahmed Mansour', 'email' => 'ahmed.mansour@example.com', 'phone' => '+20 3 555 0455', 'nationality' => 'Egypt', 'city' => 'Alexandria'],
        ['name' => 'Julia Novak', 'email' => 'julia.novak@example.com', 'phone' => '+420 2 555 0466', 'nationality' => 'Czech Republic', 'city' => 'Prague'],
        ['name' => 'Karim Benali', 'email' => 'karim.benali@example.com', 'phone' => '+213 21 555 0477', 'nationality' => 'Algeria', 'city' => 'Algiers'],
        ['name' => 'Hannah Taylor', 'email' => 'hannah.taylor@example.com', 'phone' => '+64 4 555 0488', 'nationality' => 'New Zealand', 'city' => 'Wellington'],
        ['name' => 'Ravi Sharma', 'email' => 'ravi.sharma@example.com', 'phone' => '+91 11 5555 0499', 'nationality' => 'India', 'city' => 'New Delhi'],
    ];

    public function run(): void
    {
        $preferences = [
            'High floor',
            'Quiet room',
            'Extra pillows',
            'Sea view',
            'Late checkout',
            'Early check-in',
            'Non-smoking',
            'Allergy-free bedding',
        ];

        foreach ($this->guests as $index => $data) {
            $guest = Guest::query()->firstOrCreate(
                ['email' => $data['email']],
                $data + [
                    'address' => $index % 3 === 0 ? $index.' Seaview Avenue' : null,
                    'id_type' => $index % 2 === 0 ? 'Passport' : 'National ID',
                    'id_number' => 'P-'.str_pad((string) ($index + 1000), 6, '0', STR_PAD_LEFT),
                    'country' => $data['nationality'],
                    'vip_status' => in_array($data['name'], ['Aisha Rahman', 'Emma Johansson', 'Noah Kim'], true),
                    'loyalty_points' => $index * 37,
                    'notes' => $index % 4 === 0 ? 'Repeat guest. Prefers the same room category each visit.' : null,
                ],
            );

            if ($guest->preferences()->count() === 0) {
                foreach (array_rand($preferences, min(3, count($preferences))) as $key) {
                    GuestPreference::query()->create([
                        'guest_id' => $guest->id,
                        'preference_type' => $preferences[$key],
                        'value' => 'yes',
                    ]);
                }
            }
        }
    }
}
