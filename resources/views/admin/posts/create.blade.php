<x-layouts::app>

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

    <div class="card">
        <form action="{{ route('admin.posts.store') }}" method="POST" class="space-y-4">
            @csrf

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
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    Enviar
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts::app>
