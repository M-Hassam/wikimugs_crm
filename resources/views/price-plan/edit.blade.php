@extends('layout.app')


@section('content')

{{-- <div class="modal fade zoom" tabindex="-1" id="editPricePlanModal"> --}}
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Price Plan</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <form id="editPricePlan" action="{{ route('price-plans.update',['price_plan'=>$model->id]) }}" method="post">
            	@method('patch')
            	@csrf
            	<input type="hidden" name="domain_id" value="{{ $model->domain_id }}">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Type of work <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="price_plan_type_of_work_id" class="form-select form-control form-control-lg pricePlanTypeOfWorksSelect" data-search="on">
                                    	<option></option>
                                    	@forelse($price_plan_tofs as $tof)
                                    	<option value="{{ $tof->id }}" @if($model && $model->price_plan_type_of_work_id==$tof->id) selected @endif>{{ $tof->name }}</option>
                                    	@empty
                                    	@endforelse
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Level <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="price_plan_level_id" class="form-select form-control form-control-lg pricePlanTypeOfWorksSelect" data-search="on">
                                    	<option></option>
                                    	@forelse($price_plan_levels as $ppl)
                                    	<option value="{{ $ppl->id }}" @if($model && $model->price_plan_level_id==$ppl->id) selected @endif>{{ $ppl->name }}</option>
                                    	@empty
                                    	@endforelse
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Urgencies <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="price_plan_urgency_id" class="form-select form-control form-control-lg pricePlanTypeOfWorksSelect" data-search="on">
                                    	<option></option>
                                    	@forelse($price_plan_urgencies as $ppu)
                                    	<option value="{{ $ppu->id }}" @if($model && $model->price_plan_urgency_id==$ppu->id) selected @endif>{{ $ppu->name }}</option>
                                    	@empty
                                    	@endforelse
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Price <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <input name="price" type="text" value="{{ $model->price }}" class="form-control" placeholder="Price">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
{{-- </div> --}}

@endsection