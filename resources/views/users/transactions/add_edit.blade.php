@extends('layout.app')


@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="components-preview wide-md mx-auto">
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <div class="preview-block">
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif Transaction</span>
                                @if(isset($model))
                                <form action="{{ route('users.transaction.update',['transaction'=>$model->id]) }}" method="post" enctype="multipart/form-data">
                                    @else
                                    <form action="{{ route('users.transaction.store',['user'=>$user_id]) }}" method="post" enctype="multipart/form-data">
                                        @endif
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user_id ?? null }}">
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select name="payment_mode" class="form-control guest_writer_selection" required>
                                                            <option value="">Select Payment Mode</option>
                                                            <option value="1" @if(isset($model) && $model->payment_mode==1)  selected="" @endif>Bank Transfer</option>
                                                            <option value="3" @if(isset($model) && $model->payment_mode==2)  selected="" @endif>Cheque</option>
                                                            <option value="2" @if(isset($model) && $model->payment_mode==3)  selected="" @endif>Cash</option>
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'payment_mode'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="date" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="payment_date" value="{{ old('payment_date',$model->payment_date ?? "") }}" required>
                                                        <label class="form-label-outlined" for="outlined-normal">Payment Date</label>
                                                        @include('layout.includes.form-error',['field'=>'payment_date'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="paid_amount" value="{{ old('paid_amount',$model->paid_amount ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Paid Amount</label>
                                                        @include('layout.includes.form-error',['field'=>'paid_amount'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="balance_amount" value="">
                                                        <label class="form-label-outlined" for="outlined-normal">Balance Amount</label>
                                                        @include('layout.includes.form-error',['field'=>'balance_amount'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                       <input type="file" class="form-control form-control-xl form-control-outlined" name="attachments"> 
                                                       <label class="form-label-outlined" for="outlined-normal">Attachment</label>
                                                       @include('layout.includes.form-error',['field'=>'attachments'])
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-lg-2">
                                               <a href="{{ isset($model) ? asset('uploads/files/'.$model->attachments) : '#' }}" target="_blank"><img width="80" src="{{ isset($model) ? asset('uploads/files/'.$model->attachments) : '#' }}"></a>
                                           </div>
                                       </div>
                                       <div class="row mt-4">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                   <textarea name="notes" class="form-control" placeholder="notes">{!! $model->notes ?? "" !!}</textarea>
                                                   {{-- <label class="form-label-outlined" for="outlined-normal">Attachment</label> --}}
                                                   @include('layout.includes.form-error',['field'=>'notes'])
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-lg-2"></div>
                                   </div>
                                   <div class="row mt-4">
                                    <div class="col-lg-8"></div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-success"> Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).on('change','.guest_writer_selection', function() {
        let status_id = $(this).val();
        if($(this).val()==8){
            $('.guest_writer').removeClass('d-none');
        }else{
            $('.guest_writer').addClass('d-none');
        }
    });
</script>
@endpush