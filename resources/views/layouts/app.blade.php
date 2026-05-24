<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    @stack('js') // Permite agregar scripts adicionales desde las vistas que extienden este layout

    @if (session('swal')) //condicional para mostrar el mensaje de SweetAlert2 si existe en la sesión
        <script>
            Swal.fire(@json(session('swal'))); // Convierte el mensaje de la sesión a formato JSON para usarlo en SweetAlert2
        </script>
    @endif
</x-layouts::app.sidebar>
