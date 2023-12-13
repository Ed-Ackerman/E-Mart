@extends('layouts.app-master')

@section('content')
<legend>{{ __('Return Details') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<section class="orders">
    <div class="form-product-header" style="width:100%;">
        <a href="{{ route('returns') }}">
            <i class="fa fa-arrow-left"></i>
            <span class="back">{{ __('Go Back') }}</span>
        </a>
        {{ __('Returns Information') }}
    </div>
<div class="delivery-info">
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Product Name.')}}</div>
        <div class="deliver">{{ $return_info->product_name }}</div>
    </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Product Code.')}}</div>
        <div class="deliver">{{ $return_info->product_code }}</div>
    </div>
    <div class="delivery" style="box-shadow: 0 1px 0 0 #dddddd;">
        <div class="deliver" id="deliver">{{__('Return Reason.')}}</div>
        <div class="deliver">{{ $return_info->return_reason }}</div>
    </div>
    <hr>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Client ID No.')}}</div>
        <div class="deliver">{{ $return_info->id }}</div>
    </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Name.')}}</div>
        <div class="deliver">{{ $return_info->name }}</div>
    </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Tel.')}}</div>
        <div class="deliver">
            <div class="deliver"> {{ $return_info->tel_1 }}</div>
            <div class="deliver">{{ $return_info->tel_2 }}</div> 
        </div>
   </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('City.')}}</div>
        <div class="deliver">{{ $return_info->city }}</div>
    </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Region.')}}</div>
        <div class="deliver">{{ $return_info->region }}</div>
    </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Address.')}}</div>
        <div class="deliver">{{ $return_info->address }}</div>
    </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Payment.')}}</div>
        <div class="deliver">{{ $return_info->payment_method }}</div>
    </div>
    <div class="delivery">
        <div class="deliver" id="deliver">{{__('Return Status')}}</div>
        <div class="deliver">
            @if ($return_info->return_status === 'approved')
                <div class="span approved-status">{{ __('Approved') }}</div>
            @elseif ($return_info->return_status === 'pending')
                <div class="span pending-status">{{ __('Pending') }}</div>
            @elseif ($return_info->return_status === 'denied')
                <div class="span denied-status">{{ __('Denied') }}</div>
            @endif
        </div>
    </div>
             
    <div class="delivery" style="background-color: #f6f6f6">
        <div class="deliver" id="deliver">{{__('Return Status Update.')}}</div>
        <form method="post" action="{{ route('update.return.status', $return_info->id) }}" class="deliver-form">
            @csrf
            @method('PATCH')
            <select name="return_status" id="return_status" class="form-control">
                <option value="" selected disabled>{{ __('Set Status') }}</option>
                <option value="approved" {{ $return_info->return_status === 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                <option value="pending" {{ $return_info->return_status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                <option value="denied" {{ $return_info->return_status === 'denied' ? 'selected' : '' }}>{{ __('Denied') }}</option>
            </select>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;  margin: 10px;">{{__('Update Return Status')}}</button>
        </form>
    </div>
    
</div>

@endsection