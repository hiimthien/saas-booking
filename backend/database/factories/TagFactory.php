<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            // Tech & IT
            'Laravel', 'Nuxt 3', 'Vue.js', 'UI/UX Design', 'DevOps', 'React', 'Node.js',
            'Python', 'Machine Learning', 'Data Science', 'Cloud Architecture', 'Cybersecurity',
            'Go', 'Ruby on Rails', 'PHP', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP',
            'Mobile App Development', 'iOS Swift', 'Android Kotlin', 'System Administration',
            
            // Business & Management
            'Business Strategy', 'Marketing', 'SEO', 'Leadership', 'Project Management',
            'Agile/Scrum', 'Financial Planning', 'Startup Mentoring', 'Sales Strategy',
            'Human Resources', 'Supply Chain Management', 'Public Relations', 'B2B Sales',
            
            // Legal & Compliance
            'Corporate Law', 'Intellectual Property', 'Tax Law', 'Immigration Law',
            'Contract Negotiation', 'Compliance', 'Data Privacy (GDPR)',
            
            // Healthcare & Wellness
            'Mental Health', 'Nutrition', 'Fitness Coaching', 'Medical Consulting',
            'Life Coaching', 'Holistic Health', 'Physical Therapy',
            
            // Creative & Arts
            'Graphic Design', 'Video Production', 'Copywriting', 'Interior Design',
            'Photography', 'Music Production', 'Creative Writing', 'Brand Identity',
            
            // Education & Languages
            'English Tutoring', 'Spanish Tutoring', 'Career Counseling', 'Test Preparation',
            'Special Education', 'Public Speaking', 'E-learning Design'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
