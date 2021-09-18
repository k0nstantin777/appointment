<nav class="py-3 px-6 rounded w-full">
    <ol class="list-reset flex text-grey-dark dark:text-white">
        @if(Breadcrumbs::has())
            @foreach (Breadcrumbs::current() as $crumbs)
                @if ($crumbs->url() && !$loop->last)
                    <li>
                        <a class="text-purple-600 font-bold" href="{{ $crumbs->url() }}">
                            {{ $crumbs->title() }}
                        </a>
                    </li>
                    <li><span class="mx-2">/</span></li>
                @else
                    <li class="breadcrumb-item active">
                        {{ $crumbs->title() }}
                    </li>
                @endif
            @endforeach
        @endif
    </ol>
</nav>
