<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        EmailTemplate::create([
            'name' => 'Welcome Email',
            'subject' => 'Welcome to Our Platform, {{name}}!',
            'content' => '<h1>Welcome, {{name}}!</h1><p>Thank you for joining our platform. Your registered email is {{email}}.</p><p>We are excited to have you on board!</p>',
        ]);
    }
}
