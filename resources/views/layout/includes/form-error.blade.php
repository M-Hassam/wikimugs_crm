<style type="text/css">
	.invalid-feedback{
		display: block !important;
	}
</style>
@if($errors->has($field))
<span class="invalid-feedback" role="alert">
	<strong>{{ $errors->first($field) }}</strong>
</span>
@endif