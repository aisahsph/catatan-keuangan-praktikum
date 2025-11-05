<!doctype html>
<html lang="id">

<head>
    {{-- Meta --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Icon --}}
    <link rel="icon" href="/logo.png" type="image/x-icon" />

    {{-- Judul --}}
    <title>{{ config('app.name', 'Catatan Keuangan') }}</title>

    {{-- Styles --}}
    @livewireStyles
    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @stack('styles')
</head>

<body class="bg-light">
    <div class="container-fluid">
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @stack('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            Livewire.on("closeModal", (data) => {
                const modal = bootstrap.Modal.getInstance(
                    document.getElementById(data.id)
                );
                if (modal) {
                    modal.hide();
                }
            });

            Livewire.on("showModal", (data) => {
                const modal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById(data.id)
                );
                if (modal) {
                    modal.show();
                }
            });
        });
    </script>
    @livewireScripts
</body>

</html>