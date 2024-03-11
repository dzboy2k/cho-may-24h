<div style="display: flex; justify-content: center; margin: auto; width: 70%;">
    <div style="width: 70%;">
        <div style="width: auto; margin: 0 auto;">
            <h3 style="text-align: center">{{ __('email.req-reset-password') }} Chomay24h</h3>
            <span>{{ __('email.greeting') }} {{$data['email']}},</span>
            <p>{{ __('email.reset_password_message') }}</p>
            <h5 style="text-align: center; font-weight:800">{{$data['code']}}</h5>
            <p>{{ __('email.reminder_message') }}</p>
            <p>{{ __('email.sincerely') }}<br>Chomay24h</p>
        </div>
        <div style="text-align: center; font-size: 10px;">
            <p style="margin-bottom: 0px"><i class="fa-regular fa-copyright"></i> Chomay24h</p>
            <p>{{ __('email.contact_customer_service') }}:<a href="#">
                    {{config('constants.DEFAULT_MAIL')}}</a></p>
        </div>
    </div>
</div>
