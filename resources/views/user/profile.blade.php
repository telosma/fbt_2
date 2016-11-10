@extends('layouts.userMaster')

@section('style')
    @include('includes.userStyle')
@endsection
@section('content')
@include('includes.notification')
@include('includes.error')
<div class="container">
    <div class="row">
        <div class="col-sm-4 col-lg-3">
            <div class="sidebar">
                <div class="widget">
                    <div class="user-photo">
                        <img src="{{ $user->avatar_link }}" height="200">
                        <span class="user-photo-action">{{ trans('user.photo_action') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md8 col-lg-9">
            <div class="profile-content">
                <div class="profile-title">
                    <h1>{{ trans('user.profile.message') }}</h1>
                </div>
                <div class="bg-white p20 mb30">
                    <h3 class="profile-title">
                        {{ trans('user.profile.info') }}
                        <button class="btn btn-primary pull-right">{{ trans('user.action.save_profile') }}</button>
                    </h3>
                    <div class="row">
                        {{ Form::open(['url' => '']) }}
                            <div class="form-group col-sm-6">
                                {{ Form::label('name', trans('user.profile.name')) }}
                                {{ Form::text('name', $user->name, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('email', trans('user.profile.email')) }}
                                {{ Form::text('email', $user->email, ['class' => 'form-control']) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="bg-white p20 mb30">
                    <h3 class="profile-title">
                        {{ trans('user.profile.bank_account') }}
                        <button
                            class="btn btn-primary btn-profile-save pull-right"
                            data-toggle="modal"
                            data-target="#add-bank-modal">
                            {{ trans('user.action.add_bank_account') }}
                        </button>
                    </h3>
                    <div class="row">
                        @forelse($bankAccounts as $bankAccount)
                            <div class="box-bank-account col-sm-6" id="bank-account-{{ $bankAccount->id }}">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <p>
                                            {{ $bankAccount->account }}
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        <i class="fa fa-trash del-bank-account pull-left"
                                            aria-hidden="true"
                                            data-id="{{ $bankAccount->id }}"
                                            data-message="{{trans('user.message.confirm_delete_bank')}}"
                                            data-url-delete-bank="{{ route('bank-account.destroy', $bankAccount->id) }}"
                                        >
                                        </i>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                {{ trans('user.message.null_bank_account') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="add-bank-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ trans('user.profile.modal_add_bank') }}</h2>
            </div>
            <div class="modal-body">
                {{ Form::open(['route' => 'bank-account.store', 'method' => 'POST', 'id' => 'form-add-bank']) }}
                    <div class="form-formgroup">
                        {{ Form::label('account', trans('user.profile.your_bank_account')) }}
                        {{ Form::text('account', null, ['class' => 'form-control']) }}
                        {{ Form::submit(trans('user.action.add_bank_account'), ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('label.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{{ Html::script('js/ajaxDeleteBankAccount.js') }}
@endsection
