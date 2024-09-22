<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            
            
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10 w-full">
                    <img src="{{ asset('storage/project_logo.jpg') }}" alt="Kreator logo" class="block h-9 w-auto fill-current text-gray-800 dark:hidden" srcset="">

                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="mt-16 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Welcome to Kreator
                    </h1>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg leading-relaxed">
                        Kreator is a platform designed for creators to share exclusive content with their subscribers. Empower your creativity, engage with your fans, and build a supportive community around your work.
                    </p>
                </div>
            
                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Create and Share Exclusive Content
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Post videos, blogs, and images that only your subscribers can access. Whether you're an artist, musician, or writer, Kreator gives you the tools to connect with your audience in a meaningful way.
                                </p>
                            </div>
                        </div>
            
                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Engage with Your Subscribers
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Build a community by interacting directly with your fans through comments and exclusive chat rooms. Foster relationships, answer questions, and offer a unique experience to your supporters.
                                </p>
                            </div>
                        </div>
            
                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Flexible Subscription Plans
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Set your own subscription tiers and give your fans access to different levels of content. Monetize your creativity on your own terms and grow your revenue.
                                </p>
                            </div>
                        </div>
            
                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Analytics and Insights
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Track your growth, see which content resonates with your audience, and make data-driven decisions to improve your engagement and revenue.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm sm:text-left">
                        <p class="text-gray-500 dark:text-gray-400">
                            Start creating and building your community today!
                        </p>
                    </div>
            
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>
