<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use App\Models\Quantity;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get or create quantities
        $qty250g = Quantity::firstOrCreate(
            ['name' => '250g', 'label' => '250g'],
            ['status' => 1]
        );

        $qty200g = Quantity::firstOrCreate(
            ['name' => '200g', 'label' => '200g'],
            ['status' => 1]
        );

        $qty500g = Quantity::firstOrCreate(
            ['name' => '500g', 'label' => '500g'],
            ['status' => 1]
        );

        $qty1kg = Quantity::firstOrCreate(
            ['name' => '1kg', 'label' => '1kg'],
            ['status' => 1]
        );

        // Create variants for product ID 19 (Tamarind Jams)
        ProductVariant::firstOrCreate(
            ['product_id' => 19, 'quantity_id' => $qty250g->id],
            [
                'price' => 430.00,
                'sell_price' => 400.00,
                'stock' => 100,
                'stock_status' => 'in_stock'
            ]
        );

        ProductVariant::firstOrCreate(
            ['product_id' => 19, 'quantity_id' => $qty200g->id],
            [
                'price' => 400.00,
                'sell_price' => 390.00,
                'stock' => 100,
                'stock_status' => 'in_stock'
            ]
        );

        // Create variants for product ID 18 (Jelly Bites)
        ProductVariant::firstOrCreate(
            ['product_id' => 18, 'quantity_id' => $qty250g->id],
            [
                'price' => 350.00,
                'sell_price' => 330.00,
                'stock' => 50,
                'stock_status' => 'in_stock'
            ]
        );

        ProductVariant::firstOrCreate(
            ['product_id' => 18, 'quantity_id' => $qty500g->id],
            [
                'price' => 600.00,
                'sell_price' => 580.00,
                'stock' => 75,
                'stock_status' => 'in_stock'
            ]
        );

        // Create variants for product ID 17 (Milk Chocolate)
        ProductVariant::firstOrCreate(
            ['product_id' => 17, 'quantity_id' => $qty200g->id],
            [
                'price' => 300.00,
                'sell_price' => 280.00,
                'stock' => 120,
                'stock_status' => 'in_stock'
            ]
        );

        ProductVariant::firstOrCreate(
            ['product_id' => 17, 'quantity_id' => $qty1kg->id],
            [
                'price' => 1200.00,
                'sell_price' => 1100.00,
                'stock' => 30,
                'stock_status' => 'in_stock'
            ]
        );
    }
}
