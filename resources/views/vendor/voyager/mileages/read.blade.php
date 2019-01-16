@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->display_name_singular)

@section('page_header')
<h1 class="page-title">
    <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->display_name_singular) }} &nbsp;

    @can('edit', $dataTypeContent)
    <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
        <span class="glyphicon glyphicon-pencil"></span>&nbsp;
        {{ __('voyager::generic.edit') }}
    </a>
    @endcan
    @can('delete', $dataTypeContent)
    <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
    </a>
    @endcan

    <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
        <span class="glyphicon glyphicon-list"></span>&nbsp;
        {{ __('voyager::generic.return_to_list') }}
    </a>
</h1>
@include('voyager::multilingual.language-selector')
@stop

@section('content')
<div class="page-content read container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            Information Véhicule
        </div>
        <div class="panel-body" style="margin-top: 10px;">
            <!-- Table  start -->
            <table class="table">
              <tr>
                @foreach($dataType->readRows as $row)
                @php $rowDetails = json_decode($row->details);
                if($rowDetails === null){
                $rowDetails=new stdClass();
                $rowDetails->options=new stdClass();
            }
            @endphp                             
            <td class="col-md-2" style="border-top:0px;border-bottom: 1px solid #ddd; font-weight: bold; solid #ddd">{{ $row->display_name }}</td>

            <td style="border-top:0px;font-weight: 300; vertical-align:bottom;border-left: 1px solid #000; padding: 5px;border-bottom: 1px solid #ddd;">
               @if($row->type == 'relationship')
               @include('voyager::formfields.relationship', ['view' => 'read', 'options' => $rowDetails])
               @elseif($row->type == 'select_dropdown' && property_exists($rowDetails, 'options') &&
                !empty($rowDetails->options->{$dataTypeContent->{$row->field}}))

                <?php echo $rowDetails->options->{$dataTypeContent->{$row->field}};?>
                @elseif($row->type == 'select_dropdown' && $dataTypeContent->{$row->field . '_page_slug'})
                <a href="{{ $dataTypeContent->{$row->field . '_page_slug'} }}">{{ $dataTypeContent->{$row->field}  }}</a>
                @elseif($row->type == 'select_multiple')
                @if(property_exists($rowDetails, 'relationship'))

                @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                @if($item->{$row->field . '_page_slug'})
                <a href="{{ $item->{$row->field . '_page_slug'} }}">{{ $item->{$row->field}  }}</a>@if(!$loop->last), @endif
                @else
                {{ $item->{$row->field}  }}
                @endif
                @endforeach

                @elseif(property_exists($rowDetails, 'options'))
                @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                {{ $rowDetails->options->{$item} . (!$loop->last ? ', ' : '') }}
                @endforeach
                @endif
                @elseif($row->type == 'date' || $row->type == 'timestamp')
                {{ $rowDetails && property_exists($rowDetails, 'format') ? \Carbon\Carbon::parse($dataTypeContent->{$row->field})->formatLocalized($rowDetails->format) : $dataTypeContent->{$row->field} }}
                @elseif($row->type == 'checkbox')
                @if($rowDetails && property_exists($rowDetails, 'on') && property_exists($rowDetails, 'off'))
                @if($dataTypeContent->{$row->field})
                <span class="label label-info">{{ $rowDetails->on }}</span>
                @else
                <span class="label label-primary">{{ $rowDetails->off }}</span>
                @endif
                @else
                {{ $dataTypeContent->{$row->field} }}
                @endif
                @elseif($row->type == 'color')
                <span class="badge badge-lg" style="background-color: {{ $dataTypeContent->{$row->field} }}">{{ $dataTypeContent->{$row->field} }}</span>
                @elseif($row->type == 'coordinates')
                @include('voyager::partials.coordinates')
                @elseif($row->type == 'rich_text_box')
                @include('voyager::multilingual.input-hidden-bread-read')
                {!! $dataTypeContent->{$row->field} !!}
                @elseif($row->type == 'file')
                @if(json_decode($dataTypeContent->{$row->field}))
                @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
                <a href="/storage/{{ $file->download_link or '' }}">
                    {{ $file->original_name or '' }}
                </a>
                <br/>
                @endforeach
                @else
                <a href="/storage/{{ $dataTypeContent->{$row->field} }}">
                    {{ __('voyager::generic.download') }}
                </a>
                @endif
                @else
                @include('voyager::multilingual.input-hidden-bread-read')
                {{ $dataTypeContent->{$row->field} }}
                @endif
            </div>
            @if(!$loop->last)
            @endif
        </td>
    </tr>
@endforeach
</table>   
</div>
</div>
</div>
</div>
</div>
{{-- Single delete modal --}}
<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                    aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->display_name_singular) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                        value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->display_name_singular) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @stop

    @section('javascript')
    @if ($isModelTranslatable)
    <script>
        $(document).ready(function () {
            $('.side-body').multilingual();
        });
    </script>
    <script src="{{ voyager_asset('js/multilingual.js') }}"></script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) { // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
            ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
            : deleteFormAction + '/' + $(this).data('id');
            console.log(form.action);

            $('#delete_modal').modal('show');
        });

    </script>
    @stop
