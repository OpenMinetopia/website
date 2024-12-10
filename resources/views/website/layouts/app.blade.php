<!DOCTYPE html>
<html lang="nl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OpenMinetopia - Een open-source Minecraft plugin voor het creëren van een Minetopia server">
    <title>{{ config('app.name') }} - @yield('title', 'Open Source Minetopia')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Minecraft:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* Custom cursor */
        body {
            cursor: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='8' cy='8' r='7' stroke='%23FFD700' stroke-width='1.5' stroke-opacity='0.8'/%3E%3C/svg%3E"), auto;
        }

        a, button, [role="button"] {
            cursor: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='8' cy='8' r='7' stroke='%23FFD700' stroke-width='1.5' stroke-opacity='0.8'/%3E%3Ccircle cx='8' cy='8' r='3' fill='%23FFD700' fill-opacity='0.8'/%3E%3C/svg%3E"), pointer;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 215, 0, 0.2);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 215, 0, 0.4);
        }

        .dark ::-webkit-scrollbar-thumb {
            background: rgba(255, 215, 0, 0.15);
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 215, 0, 0.3);
        }

        /* Progress bar */
        .progress-bar {
            @apply fixed top-0 left-0 h-1 bg-gold-500 z-50 transition-all duration-300;
        }

        /* Minecraft font for special elements */
        .font-minecraft {
            font-family: 'Minecraft', sans-serif;
        }

        /* Animated gradient border */
        .animate-border-gradient {
            background: linear-gradient(var(--gradient-angle), #FFD700, #FFA500, #FFD700);
            animation: gradient-rotate 3s linear infinite;
        }

        @keyframes gradient-rotate {
            0% { --gradient-angle: 0deg; }
            100% { --gradient-angle: 360deg; }
        }

        /* Page transitions */
        .page-transition {
            @apply transition-all duration-300 ease-in-out;
        }

        /* Hover effects */
        .hover-lift {
            @apply transition-transform duration-300 ease-out;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="antialiased bg-white dark:bg-gray-900 transition-colors duration-200"
      x-data="{
          darkMode: localStorage.getItem('darkMode') === 'true',
          init() {
              if (this.darkMode === null) {
                  this.darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
              }
              this.$watch('darkMode', val => {
                  localStorage.setItem('darkMode', val);
                  if (val) {
                      document.documentElement.classList.add('dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                  }
              });

              // Set initial dark mode state
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              }
          }
      }">

    <!-- Scroll Progress Bar -->
    <div class="progress-bar" id="scrollProgress"></div>

    <div class="min-h-screen flex flex-col">
        @include('website.layouts.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('website.layouts.cta')

        @include('website.layouts.footer')
    </div>

    <script>
        // Scroll Progress
        window.onscroll = function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            document.getElementById("scrollProgress").style.width = scrolled + "%";
        };

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
