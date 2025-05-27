<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run()
    {
            DB::table('tickets')->truncate();

        $tickets = [
            [
                'name' => 'Modular Asia Student Ticket',
                'price' => 249.00,
                'sku' => 'MA - student',
                'categories' => ['General', 'Modular Asia', 'Ticket'],
                'quantity_discounts' => null,
                'can_select_quantity' => false,
                'description' => 'Specially discounted for students, this ticket offers access to all Modular Asia Conference sessions at a discounted rate. A valid student ID may be required at entry.',
                'additional_info' => null,
            ],
            [
                'name' => 'Modular Asia Regular Ticket',
                'price' => 349.00,
                'sku' => 'MA - normal',
                'categories' => ['General', 'Modular Asia', 'Ticket'],
                'quantity_discounts' => null,
                'can_select_quantity' => true,
                'description' => 'A standard ticket for individual attendees to access the full Modular Asia Conference. Ideal for those seeking comprehensive event participation without additional discounts.',
                'additional_info' => null,
            ],
            [
                'name' => 'Modular Asia Early Bird Ticket',
                'price' => 249.00,
                'sku' => 'MA - early bird',
                'categories' => ['General', 'Modular Asia', 'Ticket'],
                'quantity_discounts' => null,
                'can_select_quantity' => false,
                'description' => 'Limited to the first 50 attendees, this early bird ticket offers a discounted rate for Modular Asia Conference which is perfect for those who act fast!',
                'additional_info' => null,
            ],
            [
                'name' => 'Modular Asia Group Ticket',
                'price' => 349.00,
                'sku' => 'MA - group',
                'categories' => ['General', 'Modular Asia', 'Ticket'],
                'quantity_discounts' => [
                    ['min' => 2, 'max' => 3, 'price' => 319.00],
                    ['min' => 4, 'max' => 7, 'price' => 299.00],
                    ['min' => 8, 'max' => null, 'price' => 249.00],
                ],
                'can_select_quantity' => true,
                'description' => 'Designed for groups, this ticket allows multiple attendees to participate in the Modular Asia Conference at discounted rates. Pricing tiers:\n\n2 to 3 pax: RM 319.00 per pax | USD 80.00 per pax\n4 to 7 pax: RM 299.00 per pax | USD 70.00 per pax\n8 pax and above: RM 249.00 per pax | USD 60.00 per pax\nIdeal for teams, organizations, and group learners aiming to maximize their participation.\n\nPlease update ticket amount if your initial ticket were below your desired price ticket to get the discount inside cart page',
                'additional_info' => "1-3 attendees\tRM 319.00 per pax, USD 80.00 per pax\n4-7 attendees\tRM 299.00 per pax, USD 70.00 per pax\n8 and above attendees\tRM 249.00 per pax, USD 60.00 per pax",
            ],
            [
                'name' => 'Facility Management Group Ticket',
                'price' => 319.00,
                'sku' => 'FM - group',
                'categories' => ['Facility Management', 'General', 'Ticket'],
                'quantity_discounts' => [
                    ['min' => 2, 'max' => 3, 'price' => 291.58],
                    ['min' => 4, 'max' => 7, 'price' => 273.30],
                    ['min' => 8, 'max' => null, 'price' => 227.60],
                ],
                'can_select_quantity' => true,
                'description' => 'Designed for groups, this ticket allows multiple attendees to participate in the Facility Management Conference at discounted rates. Pricing tiers:\n\n2 to 3 pax: RM 319.00 per pax | USD 80.00 per pax\n4 to 7 pax: RM 299.00 per pax | USD 70.00 per pax\n8 pax and above: RM 249.00 per pax | USD 60.00 per pax\nIdeal for teams, organizations, and group learners aiming to maximize their participation.\n\nPlease update ticket amount if your initial ticket were below your desired price ticket to get the discount inside cart page',
                'additional_info' => "1-3 attendees\tRM 319.00 per pax, USD 80.00 per pax\n4-7 attendees\tRM 299.00 per pax, USD 70.00 per pax\n8 and above attendees\tRM 249.00 per pax, USD 60.00 per pax",
            ],
            [
                'name' => 'Bina Conference Combo Ticket',
                'price' => 450.00,
                'sku' => 'bina ticket - combo',
                'categories' => ['Facility Management', 'General', 'Modular Asia', 'Ticket'],
                'quantity_discounts' => null,
                'can_select_quantity' => true,
                'description' => 'The combo package includes both the conference of Modular Asia Forum & Exhibition and the Facility Management Engagement Day',
                'additional_info' => null,
            ],
            [
                'name' => 'Facility Management Early Bird Ticket',
                'price' => 249.00,
                'sku' => 'FM - early bird',
                'categories' => ['Facility Management', 'General', 'Ticket'],
                'quantity_discounts' => null,
                'can_select_quantity' => false,
                'description' => 'Limited to the first 50 attendees, this early bird ticket offers a discounted rate for Facility Management Conference which is perfect for those who act fast!',
                'additional_info' => null,
            ],
            [
                'name' => 'Facility Management Student Ticket',
                'price' => 249.00,
                'sku' => 'FM - student',
                'categories' => ['Facility Management', 'General', 'Ticket'],
                'quantity_discounts' => null,
                'can_select_quantity' => false,
                'description' => 'Specially discounted for students, this ticket offers access to all Facility Management Conference sessions at a discounted rate. A valid student ID may be required at entry.',
                'additional_info' => null,
            ],
            [
                'name' => 'Facility Management Regular Ticket',
                'price' => 349.00,
                'sku' => 'FM - normal',
                'categories' => ['Facility Management', 'General', 'Ticket'],
                'quantity_discounts' => null,
                'can_select_quantity' => true,
                'description' => 'A standard ticket for individual attendees to access the full Facility Management Conference. Ideal for those seeking comprehensive event participation without additional discounts.',
                'additional_info' => null,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
} 