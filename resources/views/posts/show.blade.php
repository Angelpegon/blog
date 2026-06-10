<x-layouts::public>
    <article class="overflow-hidden rounded bg-white shadow-lg">
        <img class="h-96 w-full object-cover object-center" src="{{ $post->image }}"
            alt="Imagen de {{ $post->title }}">

        <div class="space-y-6 px-6 py-5">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500">
                    {{ $post->category?->name }}
                </p>
                <h1 class="text-3xl font-bold">
                    {{ $post->title }}
                </h1>

                @if ($post->excerpt)
                    <p class="text-lg text-zinc-700">
                        {{ $post->excerpt }}
                    </p>
                @endif
            </header>

            @if ($post->content)
                <div class="prose max-w-none">
                    {!! $post->content !!}
                </div>
            @endif

            @if ($post->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span class="rounded bg-zinc-100 px-2 py-1 text-sm text-zinc-700">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </article>
</x-layouts::public>
