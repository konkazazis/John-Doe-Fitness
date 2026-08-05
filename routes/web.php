<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriptionController;
use App\Livewire\Admin\Category\CategoryManager;
use App\Livewire\Admin\ClientsMessages\ClientsMessagesManager;
use App\Livewire\Admin\Contact\ContactManager;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\ExercisePlans\ExercisePlansManager;
use App\Livewire\Admin\NutritionPlans\NutritionPlansManager;
use App\Livewire\Admin\Plans\PlansManager;
use App\Livewire\Admin\Post\PostManager;
use App\Livewire\Admin\Project\ProjectManager;
use App\Livewire\Admin\Settings\Appearance as SettingsAppearance;
use App\Livewire\Admin\Settings\Profile as SettingsProfile;
use App\Livewire\Admin\Settings\Security as SettingsSecurity;
use App\Livewire\Admin\Tag\TagManager;
use App\Livewire\Admin\Testimonial\TestimonialManager;
use App\Livewire\Admin\Users\UserManager;
use App\Livewire\User\AccountHistory\AccountHistory;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Livewire\User\Messages\MessageManager;
use App\Livewire\User\MyExercise\MyExercise;
use App\Livewire\User\MyNutrition\MyNutrition;
use App\Livewire\User\MySubscription\MySubscription;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

// ─── SEO ──────────────────────────────────────────────────────────────────────

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');

// ─── User CMS ────────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::middleware(['role:user'])->group(function () {
        Route::get('/', UserDashboard::class)->name('dashboard');
        Route::get('/messages', MessageManager::class)->name('messages');
        Route::get('/my-subscription', MySubscription::class)->name('my-subscription');
        Route::get('/account-history', AccountHistory::class)->name('account-history');
        Route::get('/my-nutrition', MyNutrition::class)->name('my-nutrition');
        Route::get('/my-exercise', MyExercise::class)->name('my-exercise');
        Route::get('/subscription/change-payment-method', [MySubscription::class, 'changePaymentMethod'])
            ->name('change-payment-method');
        Route::get('/subscription/payment-method-updated', [MySubscription::class, 'paymentMethodUpdated'])
            ->name('payment-method-updated');
        Route::redirect('/settings', '/user/settings/profile')->name('settings');
        Route::get('/settings/profile', SettingsProfile::class)->name('settings.profile');
        Route::get('/settings/security', SettingsSecurity::class)->name('settings.security');
        Route::get('/settings/appearance', SettingsAppearance::class)->name('settings.appearance');
    });
});

// ─── Stripe ────────────────────────────────────────────────────────────────

Route::post('stripe/webhook', [WebhookController::class, 'handleWebhook']);

Route::middleware('auth')->group(function () {
    Route::post('/subscribe/{stripe_price_id}', [SubscriptionController::class, 'subscribe'])
        ->name('subscription.subscribe');
    Route::get('/subscription/success', [SubscriptionController::class, 'success'])
        ->name('subscription.success');
});

// ─── Admin CMS ────────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/', AdminDashboard::class)->name('dashboard');
        Route::get('/users', UserManager::class)->name('users.index');
        Route::get('/posts', PostManager::class)->name('posts.index');
        Route::get('/projects', ProjectManager::class)->name('projects.index');
        Route::get('/plans', PlansManager::class)->name('plans.index');
        Route::get('/testimonials', TestimonialManager::class)->name('testimonial.index');
        Route::get('/categories', CategoryManager::class)->name('categories.index');
        Route::get('/tags', TagManager::class)->name('tags.index');
        Route::get('/messages', ContactManager::class)->name('messages.index');
        Route::get('/client-messages', ClientsMessagesManager::class)->name('clients-messages.index');
        Route::get('/nutrition-plans', NutritionPlansManager::class)->name('nutrition-plans.index');
        Route::get('/exercise-plans', ExercisePlansManager::class)->name('exercise-plans.index');
        Route::redirect('/settings', '/admin/settings/profile')->name('settings');
        Route::get('/settings/profile', SettingsProfile::class)->name('settings.profile');
        Route::get('/settings/security', SettingsSecurity::class)->name('settings.security');
        Route::get('/settings/appearance', SettingsAppearance::class)->name('settings.appearance');
    });
});
