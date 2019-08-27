@if ($paginator->hasPages())
<nav aria-label="navigation"  class="paging-content">
    <ul class="pagination">
    @if ($paginator->currentPage()==1)
        <li class="page-item">
            <a title="{{trans('pagination.first')}}" class="page-link disable" data-page="1" disabled="disabled">
            <i class="fa fa-angle-double-left"></i></a>
        </li>
    @else
        <li class="page-item">
            <a title="{{trans('pagination.first')}}" class="page-link " data-page="1" href="{{ $paginator->url(1) }}" rel="prev" data-page="1">
            <i class="fa fa-angle-double-left"></i></a>
        </li>
    @endif
    @if ($paginator->onFirstPage())
        <li class="page-item">
            <a title="{{trans('pagination.previous')}}" class="page-link disable" data-page="1" disabled="disabled">
            <i class="fa fa-angle-left"></i>
            </a>
        </li>
    @else
        <li class="page-item">
            <a title="{{trans('pagination.previous')}}" class="page-link " href="{{ $paginator->previousPageUrl() }}" rel="prev" data-page="1" >
            <i class="fa fa-angle-left"></i>
            </a>
        </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li  class="page-item">
                <a title="{{trans('pagination.more_page')}}" class="page-link" data-page="">
                <i class="la la-ellipsis-h"></i></a>
            </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li  class="page-item"><a class="page-link active" data-page="1" title="1">{{ $page }}</a></li>
   
                @else
                   <li  class="page-item"><a class="page-link" data-page="{{ $page }}" title="{{ $page }}" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
     @if ($paginator->hasMorePages()) 
        <li class="page-item">
            <a title="{{trans('pagination.next')}}" class="page-link" data-page="2"  href="{{ $paginator->nextPageUrl() }}" rel="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    @else
        <li class="page-item">
            <a title="{{trans('pagination.next')}}" class="page-link disable" data-page="2" disabled="disabled" rel="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    @endif
     @if ($paginator->currentPage()==$paginator->toArray()['last_page'])
        <li class="page-item">
            <a title="{{trans('pagination.last')}}" class="page-link disable" data-page="{{$paginator->total()}}" disabled="disabled">
            <i class="fas fa-angle-double-right"></i>
            </a>
        </li>
    @else
        <li class="page-item">
            <a title="{{trans('pagination.last')}}" class="page-link" href="{{ $paginator->url($paginator->total()) }}" data-page="{{$paginator->lastItem()}}" >
            <i class="fas fa-angle-double-right"></i>
            </a>
        </li>
    @endif
    </ul>
</nav>
@endif
@if ($paginator->total()>0)
<!-- <div class="paging-content page-number">
    <select class="selectpicker " title="Select page size" data-width="70px" data-selected="10" tabindex="-98" name="per_page" onchange="this.form.submit()">
        <option value="10" @if ($paginator->toArray()["per_page"] == 10) {{ "selected" }} @endif>10</option>
        <option value="20" @if ($paginator->toArray()["per_page"] == 20) {{ 'selected' }} @endif>20</option>
        <option value="30" @if ($paginator->toArray()["per_page"] == 30) {{ 'selected' }} @endif>30</option>
        <option value="50" @if ($paginator->toArray()["per_page"] == 50) {{ 'selected' }} @endif>50</option>
        <option value="100" @if ($paginator->toArray()["per_page"] == 100) {{ 'selected' }} @endif>100</option>
    </select>    
    <span class="">{{trans('pagination.displaying')}} {{$paginator->toArray()['from']}} - {{$paginator->toArray()['to']}} {{trans('pagination.of')}} {{$paginator->total()}} {{trans('pagination.records')}}</span>
</div>-->
@endif
