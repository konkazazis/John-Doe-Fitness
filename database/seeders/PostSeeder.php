<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@proton.me')->first();

        if (! $author) {
            return;
        }

        $posts = [
            [
                'title' => '5 Strength Exercises Every Beginner Should Master',
                'excerpt' => 'Build a rock-solid foundation with these five compound lifts before chasing anything fancier.',
                'category' => 'Strength Training',
                'tags' => ['beginner', 'muscle-gain'],
                'days_ago' => 21,
            ],
            [
                'title' => 'How Much Protein Do You Actually Need?',
                'excerpt' => 'Cutting through the noise on daily protein targets for muscle growth and recovery.',
                'category' => 'Nutrition',
                'tags' => ['meal-prep', 'muscle-gain'],
                'days_ago' => 14,
            ],
            [
                'title' => 'A 20-Minute Home Cardio Routine That Actually Works',
                'excerpt' => 'No equipment, no excuses — just an effective interval session you can do in your living room.',
                'category' => 'Cardio',
                'tags' => ['home-workout', 'fat-loss'],
                'days_ago' => 10,
            ],
            [
                'title' => 'Why Mobility Work Belongs in Every Program',
                'excerpt' => 'Ten minutes of mobility a day can be the difference between progress and a nagging injury.',
                'category' => 'Mobility',
                'tags' => ['recovery'],
                'days_ago' => 6,
            ],
            [
                'title' => 'Staying Consistent When Motivation Runs Out',
                'excerpt' => 'Motivation is unreliable — here is how to build systems that keep you showing up anyway.',
                'category' => 'Mindset',
                'tags' => ['motivation'],
                'days_ago' => 3,
            ],
            [
                'title' => 'Meal Prep 101: A Simple Weekly System',
                'excerpt' => 'A draft outline for a beginner-friendly meal prep guide — still being polished.',
                'category' => 'Nutrition',
                'tags' => ['meal-prep', 'beginner'],
                'days_ago' => null,
            ],
        ];

        foreach ($posts as $data) {
            $category = Category::where('name', $data['category'])->first();

            $post = Post::firstOrCreate(
                ['title' => $data['title']],
                [
                    'user_id' => $author->id,
                    'category_id' => $category?->id,
                    'slug' => Post::generateSlug($data['title']),
                    'excerpt' => $data['excerpt'],
                    'content' => '<p>'.$data['excerpt'].'</p><p>Full write-up coming soon — this is placeholder seed content.</p>',
                    'status' => $data['days_ago'] !== null ? 'published' : 'draft',
                    'published_at' => $data['days_ago'] !== null ? now()->subDays($data['days_ago']) : null,
                ]
            );

            $tagIds = Tag::whereIn('name', $data['tags'])->pluck('id');
            $post->tags()->syncWithoutDetaching($tagIds);
        }
    }
}
