@extends('voyager::master')
@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)
@section('page_header')
<div class="container-fluid">
	<h1 class="page-title">
	<i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
	</h1>
	<button id="btn" class="btn btn-primary"><i class="fas fa-save"></i> Export to excel</button>
	<a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
		<i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
	</a>
	@include('voyager::partials.bulk-delete')
	@include('voyager::multilingual.language-selector')
</div>
@stop
@section('javascript')
				<script>
			$(document).ready(function () {
				$('#dataContent').show();
			@if (!$dataType->server_side)
			var table = $('#dataTable').DataTable({!! json_encode(array_merge(["processing"=>true,"scrollY"=>1000,"scrollCollapse"=> true,"scroller"=>true,"select"=>true,"language" => __('voyager::datatable')],config('voyager.dashboard.data_tables', []))
			, true) !!});
			@else
			$('#search-input select').select2({minimumResultsForSearch: Infinity});
			@endif
			$('.select_all').on('click', function(e) {
			$('input[name="row_id"]').prop('checked', $(this).prop('checked'));
			});
			});
			var deleteFormAction;
			$('td').on('click', '.delete', function (e) {
			$('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
			$('#delete_modal').modal('show');
			});
			</script>	
       	<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
			<script type="text/javascript">
			$('#btn').click(function() {
			$('.dataTable').table2excel({
			exclude:".noExl",
			name:"my work",
			filename:"mileage"
			});
			});
			</script>
			@stop
@section('content')
<div class="page-content browse container-fluid">
	@include('voyager::alerts')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="dataTable" class="display compact stripe nowrap" role="grid">
							<thead>
								<tr>
									<th><input type="checkbox" class="select_all"></th>
									@foreach($dataType->browseRows as $row)
									<th>{{ $row->display_name }}</th>
									@endforeach
									<th class="actions">{{ __('voyager::generic.actions') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($dataTypeContent as $data)
								<tr>
								<td><input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}"></td>
									@foreach($dataType->browseRows as $row)
									<td>{{ $data->{$row->field} }}</td>
									@endforeach
									<td class="no-sort no-click" id="bread-actions">
										@foreach(Voyager::actions() as $action)
										@include('voyager::bread.partials.actions', ['action' => $action])
										@endforeach
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
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
				<form action="#" id="delete_form" method="POST">
					{{ method_field("DELETE") }}
					{{ csrf_field() }}
					<input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
				</form>
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
			</div>
			</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
@stop
	
			