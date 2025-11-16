<?php

namespace Database\Seeders;

use App\Models\Dealer;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dealers = Dealer::all();

        $vehicles = [
            // Premium Motors (Luxury)
            [
                'make' => 'BMW',
                'model' => 'M3 Competition',
                'variant' => 'xDrive',
                'year' => 2023,
                'price' => 74995,
                'mileage' => 5200,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'body_type' => 'Saloon',
                'engine_size' => '3.0L',
                'doors' => 4,
                'color' => 'Sapphire Black',
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'E-Class',
                'variant' => 'E220d AMG Line',
                'year' => 2022,
                'price' => 42995,
                'mileage' => 12500,
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'body_type' => 'Saloon',
                'engine_size' => '2.0L',
                'doors' => 4,
                'color' => 'Polar White',
            ],
            // Manchester Motor Group (Mixed)
            [
                'make' => 'Audi',
                'model' => 'Q5',
                'variant' => '40 TDI Quattro S Line',
                'year' => 2023,
                'price' => 48995,
                'mileage' => 8900,
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'body_type' => 'SUV',
                'engine_size' => '2.0L',
                'doors' => 5,
                'color' => 'Navarra Blue',
            ],
            [
                'make' => 'Volkswagen',
                'model' => 'Golf',
                'variant' => 'GTI',
                'year' => 2022,
                'price' => 31995,
                'mileage' => 15400,
                'fuel_type' => 'Petrol',
                'transmission' => 'Manual',
                'body_type' => 'Hatchback',
                'engine_size' => '2.0L',
                'doors' => 5,
                'color' => 'Deep Black Pearl',
            ],
            // Edinburgh Elite (Performance)
            [
                'make' => 'Porsche',
                'model' => '911',
                'variant' => 'Carrera S',
                'year' => 2021,
                'price' => 99995,
                'mileage' => 8200,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'body_type' => 'Coupe',
                'engine_size' => '3.0L',
                'doors' => 2,
                'color' => 'Racing Yellow',
            ],
            [
                'make' => 'Range Rover',
                'model' => 'Sport',
                'variant' => 'HSE Dynamic',
                'year' => 2022,
                'price' => 78995,
                'mileage' => 10300,
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'body_type' => 'SUV',
                'engine_size' => '3.0L',
                'doors' => 5,
                'color' => 'Santorini Black',
            ],
            // Birmingham Budget Motors (Affordable)
            [
                'make' => 'Ford',
                'model' => 'Focus',
                'variant' => 'Titanium',
                'year' => 2020,
                'price' => 14995,
                'mileage' => 28500,
                'fuel_type' => 'Petrol',
                'transmission' => 'Manual',
                'body_type' => 'Hatchback',
                'engine_size' => '1.0L',
                'doors' => 5,
                'color' => 'Magnetic Grey',
            ],
            [
                'make' => 'Vauxhall',
                'model' => 'Corsa',
                'variant' => 'SRi',
                'year' => 2021,
                'price' => 12495,
                'mileage' => 18200,
                'fuel_type' => 'Petrol',
                'transmission' => 'Manual',
                'body_type' => 'Hatchback',
                'engine_size' => '1.2L',
                'doors' => 5,
                'color' => 'Power Red',
            ],
        ];

        foreach ($vehicles as $index => $vehicleData) {
            $dealer = $dealers[$index % $dealers->count()];

            $vehicle = Vehicle::create([
                'dealer_id' => $dealer->id,
                'make' => $vehicleData['make'],
                'model' => $vehicleData['model'],
                'variant' => $vehicleData['variant'] ?? null,
                'year' => $vehicleData['year'],
                'price' => $vehicleData['price'],
                'mileage' => $vehicleData['mileage'],
                'mileage_unit' => 'miles',
                'fuel_type' => $vehicleData['fuel_type'],
                'transmission' => $vehicleData['transmission'],
                'body_type' => $vehicleData['body_type'],
                'engine_size' => $vehicleData['engine_size'],
                'doors' => $vehicleData['doors'],
                'seats' => 5,
                'exterior_color' => $vehicleData['color'],
                'condition' => 'used',
                'previous_owners' => rand(1, 2),
                'service_history' => 'Full',
                'hpi_clear' => true,
                'mot_expiry' => now()->addMonths(rand(6, 18)),
                'tax_expiry' => now()->addMonths(rand(3, 12)),
                'description' => "Excellent condition {$vehicleData['make']} {$vehicleData['model']}. Recently serviced with full service history. HPI clear. Part exchange welcome.",
                'status' => 'available',
                'featured' => $index < 3, // First 3 are featured
                'views_count' => rand(50, 500),
                'leads_count' => rand(2, 15),
                'features' => [
                    'Cruise Control',
                    'Air Conditioning',
                    'Bluetooth',
                    'Parking Sensors',
                    'Alloy Wheels',
                ],
            ]);

            // Add placeholder images
            for ($i = 1; $i <= 5; $i++) {
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'path' => "vehicles/{$vehicle->id}/image-{$i}.jpg",
                    'url' => "https://via.placeholder.com/800x600/666/fff?text={$vehicleData['make']}+{$vehicleData['model']}",
                    'order' => $i,
                    'is_primary' => $i === 1,
                    'caption' => $i === 1 ? 'Front view' : null,
                ]);
            }
        }
    }
}
