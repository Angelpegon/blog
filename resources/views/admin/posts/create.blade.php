<x-layouts::app>

    @push('css')
        <!-- Include stylesheet -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    @endpush
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.posts.index')">
            Posts
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Nuevo
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="relative mb-2">
            <img id="imgPreview" class="w-full aspect-video object-cover object-center"
                src="{{ 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMmyTPv4M5fFPvYLrMzMQcPD_VO34ByNjouQ&s' }}"
                alt="Imagen del post">
            <div class="absolute top-8 right-8 font-bold">
                <label>
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event, '#imgPreview')"
                        class="hidden">
                    <span class="px-4 py-2 bg-white rounded-lg cursor-pointer">
                        Insertar imagen
                    </span>
                </label>
            </div>
        </div>
        <div class="card space-y-4">
            <flux:input label="Título" name="title" value="{{ old('title') }}"
                oninput="string_to_slug(this.value, '#slug')" placeholder="Escriba el título del post" />

            <flux:input label="slug" id="slug" name="slug" value="{{ old('slug') }}"
                placeholder="Escriba el slug del post" />

            <flux:select label="Categoría" name="category_id">
                <option value="">Seleccione una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </flux:select>
            <flux:textarea label="Resumen" name="excerpt" placeholder="Escriba el resumen del post">
                {{ old('excerpt') }}
            </flux:textarea>
            <div>
                <p class="text-sm font-medium mb-1">Contenido</p>
                <div id="editor">{!! old('content') !!}</div>
                <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
            </div>
            <div>
                <p class="text-sm font-medium mb-1">Etiquetas</p>
                <ul>
                    @foreach ($tags as $tag)
                        <li>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    @checked(in_array($tag->id, old('tags', [])))>
                                <span>
                                    {{ $tag->name }}
                                </span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    Enviar
                </flux:button>
            </div>
        </div>
    </form>

    @push('js')
        <!-- Include the Quill library -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <!-- Initialize Quill editor -->
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });
            quill.on('text-change', function() {
                document.getElementById('content').value = quill.root
                    .innerHTML; // Sin .innerHTML se obtiene el texto sin formato
            });
        </script>
    @endpush <!-- Permite agregar scripts adicionales desde las vistas que extienden este layout -->

</x-layouts::app>
