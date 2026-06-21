<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} — JTIK Showcase Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $styles ?? '' }}
</head>
<body class="bg-surface font-sans text-[14px] text-ink-900">

    <div class="flex min-h-screen">

        <x-admin.sidebar />

        <div class="ml-sidebar flex min-w-0 flex-1 flex-col">

            <x-admin.navbar :eyebrow="$eyebrow ?? 'Admin'" :title="$title ?? 'Dashboard'" />

            <main class="px-7 pb-[60px] pt-[26px]">
                {{ $slot }}
            </main>

            <x-admin.footer />

        </div>

    </div>

    {{ $scripts ?? '' }}

</body>
</html>
