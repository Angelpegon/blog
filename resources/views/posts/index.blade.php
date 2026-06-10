<x-layouts::public>
    <ul class="space-y-6 mb-4">
        @if ($posts->count())
            @foreach ($posts as $post)
                <li>
                    <article class="overflow-hidden rounded bg-white shadow-lg">
                        <a href="{{ route('posts.show', $post) }}">
                            <img class="h-72 w-full object-cover object-center" src="{{ $post->image }}"
                                alt="Imagen de {{ $post->title }}">
                        </a>
                        <div class="space-y-2 px-4 py-3">
                            <p class="text-sm text-zinc-500">
                                {{ $post->category?->name }}
                            </p>
                            <h1 class="text-xl font-semibold">
                                <a href="{{ route('posts.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h1>

                            @if ($post->excerpt)
                                <p>
                                    {{ $post->excerpt }}
                                </p>
                            @endif
                        </div>
                    </article>
                </li>
            @endforeach
        @else
            <li class="rounded bg-white p-6 text-center text-zinc-600 shadow">
                No hay publicaciones disponibles.
            </li>
        @endif
    </ul>
    <div>
        {{ $posts->links() }}
    </div>
</x-layouts::public>
