<div class="form-group{{ $errors->has($input_name->toHtml()) ? ' has-error has-danger' : '' }}{{ $errors->has($input_name->toHtml()) ? ' has-error has-danger' : '' }}">
    <label class="control-label mb-10" for="name">{{ $slot }}</label>
    @if($show_only->toHtml() == "true")
		<p class="form-control-static">{{ $input_value }}</p>
    @else
    	<input value="{{ $input_value }}" 
                type="{{ $input_type }}" 
                name="{{ $input_name }}" 
                class="form-control" 
                required="" 
                id="{{ $input_name }}" 
                placeholder="{{ $input_placeholder }}" 
                @if(isset($vmodel)) v-model="{{ $vmodel->toHtml() }}" @endif
                @if(isset($actions)) {{ $actions }} @endif />
    @endif
    @if(isset($extra_information))
        {{ $extra_information }}
    @endif
    @if($errors->has($input_name->toHtml()))
        <div class="help-block with-errors">
            <ul class="list-unstyled">
                <li>{{ $errors->first($input_name->toHtml()) }}</li>
            </ul>
        </div>
    @endif
</div>