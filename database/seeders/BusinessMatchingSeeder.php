<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessMatching;
use App\Models\BusinessMatchingPanel;
use App\Models\BusinessMatchingTimeSlot;
use App\Models\Event;

class BusinessMatchingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a sample event
        $event = Event::first();
        if (!$event) {
            $event = Event::create([
                'title' => 'BINA CIDB IBS 2024',
                'description' => 'Building Information and Networking Asia - Construction Industry Development Board - Industrialised Building System',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(32),
                'location' => 'Kuala Lumpur Convention Centre',
                'organizer' => 'BINA CIDB',
                'is_published' => true
            ]);
        }

        // Create Business Matching Session
        $businessMatching = BusinessMatching::create([
            'event_id' => $event->id,
            'name' => 'Business Matching Session - Day 1',
            'description' => 'Connect with industry leaders, explore partnership opportunities, and expand your business network in the construction and building industry.',
            'date' => now()->addDays(30),
            'start_time' => '14:30:00',
            'end_time' => '16:30:00',
            'is_active' => true
        ]);

        // Create Panels
        $panels = [
            ['name' => 'Technology & Innovation', 'description' => 'Focus on construction technology, BIM, and digital transformation'],
            ['name' => 'Sustainable Construction', 'description' => 'Green building practices, renewable energy, and environmental solutions'],
            ['name' => 'Manufacturing & Prefabrication', 'description' => 'Industrialized building systems and modular construction'],
            ['name' => 'Infrastructure Development', 'description' => 'Large-scale infrastructure projects and urban planning'],
            ['name' => 'Supply Chain & Logistics', 'description' => 'Material sourcing, logistics optimization, and supply chain management'],
            ['name' => 'Investment & Finance', 'description' => 'Project financing, investment opportunities, and financial solutions'],
            ['name' => 'Training & Development', 'description' => 'Skills development, certification programs, and workforce training'],
            ['name' => 'Government Relations', 'description' => 'Policy advocacy, regulatory compliance, and government partnerships']
        ];

        foreach ($panels as $index => $panel) {
            BusinessMatchingPanel::create([
                'business_matching_id' => $businessMatching->id,
                'name' => $panel['name'],
                'description' => $panel['description'],
                'order' => $index + 1,
                'is_active' => true
            ]);
        }

        // Create Time Slots (15-minute intervals)
        $timeSlots = [
            ['start_time' => '14:30:00', 'end_time' => '14:45:00'],
            ['start_time' => '14:45:00', 'end_time' => '15:00:00'],
            ['start_time' => '15:00:00', 'end_time' => '15:15:00'],
            ['start_time' => '15:15:00', 'end_time' => '15:30:00'],
            ['start_time' => '15:30:00', 'end_time' => '15:45:00'],
            ['start_time' => '15:45:00', 'end_time' => '16:00:00'],
            ['start_time' => '16:00:00', 'end_time' => '16:15:00'],
            ['start_time' => '16:15:00', 'end_time' => '16:30:00']
        ];

        foreach ($timeSlots as $index => $slot) {
            BusinessMatchingTimeSlot::create([
                'business_matching_id' => $businessMatching->id,
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
                'order' => $index + 1,
                'is_active' => true
            ]);
        }

        // Create a second Business Matching Session for Day 2
        $businessMatching2 = BusinessMatching::create([
            'event_id' => $event->id,
            'name' => 'Business Matching Session - Day 2',
            'description' => 'Second day of business matching opportunities with different focus areas and networking sessions.',
            'date' => now()->addDays(31),
            'start_time' => '14:30:00',
            'end_time' => '16:30:00',
            'is_active' => true
        ]);

        // Create Panels for Day 2
        $panels2 = [
            ['name' => 'Digital Construction', 'description' => 'AI, IoT, and smart construction technologies'],
            ['name' => 'Quality & Safety', 'description' => 'Quality management systems and safety protocols'],
            ['name' => 'International Markets', 'description' => 'Global expansion and international partnerships'],
            ['name' => 'Research & Development', 'description' => 'Innovation labs, R&D partnerships, and technology transfer'],
            ['name' => 'Legal & Compliance', 'description' => 'Regulatory compliance, legal frameworks, and policy updates'],
            ['name' => 'Marketing & Branding', 'description' => 'Brand development, marketing strategies, and market positioning'],
            ['name' => 'Human Resources', 'description' => 'Talent acquisition, workforce planning, and HR solutions'],
            ['name' => 'Consulting Services', 'description' => 'Professional consulting, advisory services, and expertise sharing']
        ];

        foreach ($panels2 as $index => $panel) {
            BusinessMatchingPanel::create([
                'business_matching_id' => $businessMatching2->id,
                'name' => $panel['name'],
                'description' => $panel['description'],
                'order' => $index + 1,
                'is_active' => true
            ]);
        }

        // Create Time Slots for Day 2
        foreach ($timeSlots as $index => $slot) {
            BusinessMatchingTimeSlot::create([
                'business_matching_id' => $businessMatching2->id,
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
                'order' => $index + 1,
                'is_active' => true
            ]);
        }

        $this->command->info('Business Matching data seeded successfully!');
        $this->command->info('Created 2 business matching sessions with 8 panels each');
        $this->command->info('Created 8 time slots per session (15-minute intervals)');
    }
}