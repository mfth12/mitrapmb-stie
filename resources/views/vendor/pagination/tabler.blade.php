@if ($paginator->hasPages())
  <ul class="pagination mb-0">
    {{-- Previous Page --}}
    @if ($paginator->onFirstPage())
      <li class="page-item disabled">
        <span class="page-link">
          <i class="ti ti-chevron-left"></i>
        </span>
      </li>
    @else
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
          <i class="ti ti-chevron-left"></i>
        </a>
      </li>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
      {{-- "Three Dots" Separator --}}
      @if (is_string($element))
        <li class="page-item disabled">
          <span class="page-link">{{ $element }}</span>
        </li>
      @endif

      {{-- Array Of Links --}}
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <li class="page-item active">
              <span class="page-link">{{ $page }}</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next Page --}}
    @if ($paginator->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
          <i class="ti ti-chevron-right"></i>
        </a>
      </li>
    @else
      <li class="page-item disabled">
        <span class="page-link">
          <i class="ti ti-chevron-right"></i>
        </span>
      </li>
    @endif
  </ul>
@endif
