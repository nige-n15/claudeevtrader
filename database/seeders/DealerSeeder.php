<?php

namespace Database\Seeders;

use App\Models\Dealer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Premium Motors - Phone & Email only (traditional approach)
        $dealer1 = Dealer::create([
            'name' => 'Premium Motors Ltd',
            'trading_name' => 'Premium Motors',
            'company_number' => 'GB12345678',
            'email' => 'sales@premiummotors.co.uk',
            'phone' => '020 7946 0958',
            'website' => 'https://premiummotors.co.uk',
            'address_line_1' => '123 High Street',
            'city' => 'London',
            'postcode' => 'SW1A 1AA',
            'country' => 'GB',
            'description' => 'London\'s premier luxury car dealership. Specializing in high-end German and British marques.',
            'display_phone' => true,
            'display_email' => true,
            'allow_reservations' => false,
            'status' => 'active',
            'contact_preferences' => [
                'enabled_methods' => ['phone', 'email'],
                'primary_cta' => 'phone',
                'show_phone' => true,
                'show_email' => true,
                'show_test_drive' => false,
                'show_reservation' => false,
                'response_time_commitment' => 'within 1 hour during business hours',
                'whatsapp_number' => null,
            ],
        ]);

        User::create([
            'dealer_id' => $dealer1->id,
            'name' => 'James Wilson',
            'email' => 'james@premiummotors.co.uk',
            'password' => Hash::make('password'),
            'role' => 'dealer_owner',
            'is_active' => true,
        ]);

        // 2. Manchester Motor Group - All features enabled (modern approach)
        $dealer2 = Dealer::create([
            'name' => 'Manchester Motor Group PLC',
            'trading_name' => 'MMG',
            'company_number' => 'GB87654321',
            'email' => 'info@mmgcars.co.uk',
            'phone' => '0161 496 0123',
            'website' => 'https://mmgcars.co.uk',
            'address_line_1' => '45 Oxford Road',
            'city' => 'Manchester',
            'county' => 'Greater Manchester',
            'postcode' => 'M1 5QA',
            'country' => 'GB',
            'description' => 'Manchester\'s largest multi-franchise dealership group. Award-winning customer service.',
            'display_phone' => true,
            'display_email' => true,
            'allow_reservations' => true,
            'status' => 'active',
            'contact_preferences' => [
                'enabled_methods' => ['phone', 'email', 'test_drive', 'reservation', 'whatsapp'],
                'primary_cta' => 'reservation',
                'show_phone' => true,
                'show_email' => true,
                'show_test_drive' => true,
                'show_reservation' => true,
                'reservation_settings' => [
                    'deposit_amount' => 199,
                    'expiry_hours' => 48,
                    'terms' => 'Fully refundable if vehicle not as described',
                ],
                'response_time_commitment' => 'within 30 minutes',
                'whatsapp_number' => '+447700900123',
            ],
        ]);

        User::create([
            'dealer_id' => $dealer2->id,
            'name' => 'Sarah Thompson',
            'email' => 'sarah@mmgcars.co.uk',
            'password' => Hash::make('password'),
            'role' => 'dealer_owner',
            'is_active' => true,
        ]);

        User::create([
            'dealer_id' => $dealer2->id,
            'name' => 'Mike Johnson',
            'email' => 'mike@mmgcars.co.uk',
            'password' => Hash::make('password'),
            'role' => 'dealer_staff',
            'is_active' => true,
        ]);

        // 3. Edinburgh Elite Autos - Email & Test Drive focus
        $dealer3 = Dealer::create([
            'name' => 'Edinburgh Elite Autos Limited',
            'trading_name' => 'Elite Autos',
            'company_number' => 'SC123456',
            'email' => 'contact@eliteautos.scot',
            'phone' => '0131 496 0789',
            'website' => 'https://eliteautos.scot',
            'address_line_1' => '78 Princes Street',
            'city' => 'Edinburgh',
            'county' => 'Midlothian',
            'postcode' => 'EH2 2ER',
            'country' => 'GB',
            'description' => 'Scotland\'s finest selection of performance and luxury vehicles.',
            'display_phone' => false,
            'display_email' => true,
            'allow_reservations' => false,
            'status' => 'active',
            'contact_preferences' => [
                'enabled_methods' => ['email', 'test_drive'],
                'primary_cta' => 'email',
                'show_phone' => false,
                'show_email' => true,
                'show_test_drive' => true,
                'show_reservation' => false,
                'response_time_commitment' => 'within 2 hours',
                'whatsapp_number' => null,
            ],
        ]);

        User::create([
            'dealer_id' => $dealer3->id,
            'name' => 'Andrew MacDonald',
            'email' => 'andrew@eliteautos.scot',
            'password' => Hash::make('password'),
            'role' => 'dealer_owner',
            'is_active' => true,
        ]);

        // 4. Birmingham Budget Motors - Simple email only
        $dealer4 = Dealer::create([
            'name' => 'Birmingham Budget Motors Ltd',
            'trading_name' => 'BBM',
            'company_number' => 'GB55667788',
            'email' => 'sales@bbmotors.co.uk',
            'phone' => '0121 496 0456',
            'address_line_1' => '234 High Street',
            'city' => 'Birmingham',
            'county' => 'West Midlands',
            'postcode' => 'B1 1AA',
            'country' => 'GB',
            'description' => 'Affordable quality used cars in Birmingham. Family-run business since 1985.',
            'display_phone' => true,
            'display_email' => true,
            'allow_reservations' => false,
            'status' => 'active',
            'contact_preferences' => [
                'enabled_methods' => ['email', 'phone'],
                'primary_cta' => 'email',
                'show_phone' => true,
                'show_email' => true,
                'show_test_drive' => false,
                'show_reservation' => false,
                'response_time_commitment' => 'within 4 hours',
                'whatsapp_number' => null,
            ],
        ]);

        User::create([
            'dealer_id' => $dealer4->id,
            'name' => 'David Patel',
            'email' => 'david@bbmotors.co.uk',
            'password' => Hash::make('password'),
            'role' => 'dealer_owner',
            'is_active' => true,
        ]);

        // Platform Admin User (no dealer association)
        User::create([
            'dealer_id' => null,
            'name' => 'Platform Admin',
            'email' => 'admin@n1g3evtrader.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
