@if ($paginator->hasPages())
    <ul class="subcategory__pagination" role="navigation">
        @if ($paginator->onFirstPage())
        @else
            <li><a class="prev" href="{{ $paginator->previousPageUrl() }}">Назад</a></li>
        @endif
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a class="current" href="{{ $url }}" @click.prevent>{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li><a class="next" href="{{ $paginator->nextPageUrl() }}">Вперед</a></li>
        @endif
    </ul>
@endif
