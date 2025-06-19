@php
    $rowActions = $getActions();
    $filters = $getFilters();
    $paginator = $getPaginator();
@endphp
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            @if(!empty($filters))
                <form action="{{request()->fullUrl()}}" class="d-flex gap-1">
                    @foreach($filters as $filter)
                        {!! render($filter)!!}
                    @endforeach
                    @if(request('sort_by'))
                        <input type="hidden" name="sort_by" value="{{request('sort_by')}}">
                        <input type="hidden" name="sort_type" value="{{request('sort_type')}}">
                    @endif
                    <button class="btn btn-outline-primary" type="submit"><i class="ri-search-line"></i></button>
                </form>
            @endif
            <div class="d-flex gap-1">
                {!! render($getTools()) !!}
            </div>
        </div>
    </div>
    <div class="card-body p-0 table-responsive" id="container_{{$getId()}}">
        {!! render($getComponents('before')) !!}
        <div batch-actions class="d-flex p-2 align-items-center gap-1 d-none">
            <span class="total">-</span> selected
            <button class="btn btn-primary btn-sm">Publish</button>
        </div>
        <table {{ $attributes->merge(['class' => 'table mb-0']) }} id="{{$getId()}}">
            <thead>
            <tr>
                @if($isSelectable())
                    <th><input data-table-select-all data-table-id="{{$getId()}}"
                               type="checkbox" class="form-check-input"></th>
                @endif
                @foreach($getColumns() as $column)
                    {!!render($column->getHeader())!!}
                @endforeach
                @if(!empty($rowActions))
                    <th>{{__('merlion::base.actions')}}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($getRows() as $row)
                <tr>
                    @if($isSelectable())
                        <td>
                            <input data-table-select data-table-id="{{$getId()}}"
                                   data-row-id="{{data_get($row, 'id')}}"
                                   type="checkbox"
                                   class="form-check-input">
                        </td>
                    @endif
                    @foreach($getColumns() as $column)
                        <td>{!!render(deep_clone($column), ['model' => $row])!!}</td>
                    @endforeach
                    @if(!empty($rowActions))
                        <td>
                            <div class="d-flex gap-1">
                                {!! render(deep_clone($rowActions), ['model' => $row]) !!}
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer pb-0">
        {!! $paginator !!}
    </div>
</div>

@pushonce('styles')
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
@endpushonce

@pushonce('scripts')
    <script>
        function updateSelectCount(table_id) {
            let selected = $('[data-table-select][data-table-id="' + table_id + '"]:checked').map(function () {
                return $(this).data('row-id');
            });
            if (selected.length === 0) {
                $('#container_' + table_id + ' [batch-actions]').addClass('d-none');
            } else {
                $('#container_' + table_id + ' [batch-actions]').removeClass('d-none');
                $('#container_' + table_id + ' [batch-actions] span.total').text(selected.length);
            }
        }

        $(function () {
            $('[data-table-select-all]').on('change', function () {
                let table_id = $(this).data('table-id');
                $('[data-table-select][data-table-id="' + table_id + '"]').prop('checked', $(this).prop('checked'));
                updateSelectCount(table_id);
            });
            $('[data-table-select]').on('change', function () {
                let table_id = $(this).data('table-id');
                updateSelectCount(table_id);
            })
        });
    </script>
@endpushonce


