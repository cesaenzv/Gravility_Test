@extends('app')

@section('content')
<style type="text/css">
	#consultasList {
	  list-style: none;
	  overflow-y: scroll;
	  max-height: 300px;
	}

</style>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Insert</div>
				<div class="panel-body">
					<form class="form-horizontal" id="formText" role="form" method="POST" action="{{ url('/home/process') }}">
						<div class="form-group">
							<label class="col-md-2 control-label">Input Data</label>
							<div class="col-md-9">
								<textarea rows="10" class="form-control" name="textInput"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-2 col-md-offset-10">
								<button type="submit" class="btn btn-primary">Send</button>
							</div>
						</div>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Results</div>
				<div class="panel-body">
					<section>
						<div class="col-md-4">
							<div class="list-group" id="consultasList">
								
							</div>
						</div>
						<div class="col-md-4">
							<h4>In</h4>
							<textarea id="textIn" rows="10" class="form-control" readonly></textarea>
						</div>
						<div class="col-md-4">	
							<h4>Out</h4>
							<textarea id="textOut" rows="10"  class="form-control" readonly></textarea>						
						</div>
					<section>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('scritps')
	<script type="text/javascript">
		(function($) {
			$.fn.serializeFormJSON = function() {
			   var o = {};
			   var a = this.serializeArray();
			   $.each(a, function() {
			       if (o[this.name]) {
			           if (!o[this.name].push) {
			               o[this.name] = [o[this.name]];
			           }
			           o[this.name].push(this.value || '');
			       } else {
			           o[this.name] = this.value || '';
			       }
			   });
			   return o;
			};
		})(jQuery);
	</script>
	<script src="{{URL::asset('scripts/utilities.js')}}" type="text/javascript"></script>
	<script src="{{URL::asset('scripts/testManager.js')}}" type="text/javascript"></script>
@endsection
