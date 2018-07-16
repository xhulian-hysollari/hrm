<div class="modal fade" tabindex="-1" role="dialog" id="confirm-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('app.close')}}"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans('app.confirm_action')}}</h4>
      </div>
      {{Form::open()}}
      <div class="modal-body">
        <p>{{trans('app.proceed_question')}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('app.cancel')}}</button>
        {!! Form::submit(trans('app.confirm'), ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="{{asset('vendors/js/jquery.min.js')}}"></script>
<script src="{{asset('vendors/js/popper.min.js')}}"></script>
<script src="{{asset('vendors/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/pace.min.js')}}"></script>
<script src="{{asset('vendors/js/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/gauge.min.js')}}"></script>
<script src="{{asset('vendors/js/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/daterangepicker.min.js')}}"></script>