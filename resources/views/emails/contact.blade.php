<h3>{{ trans('messages.new_contact') }}</h3>
<div>
    {!! $bodyMessage !!}
</div>
<p>{{ trans('messages.customer_email', ['email' => $email]) }}</p>
<p>{{ trans('messages.customer_phone', ['phone' => $phone]) }}</p>
