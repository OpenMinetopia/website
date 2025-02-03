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

    <div class="min-h-screen flex flex-col">
        @include('website.layouts.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('website.layouts.cta')

        @include('website.layouts.footer')
    </div>

</body>
</html>
