@component('mail::message')
# Новая заявка с сайта

**Имя:** {{ $data['name'] }}
**Телефон:** {{ $data['phone'] }}
@if(!empty($data['city']))
**Город:** {{ $data['city'] }}
@endif

@component('mail::button', ['url' => 'tel:'.$data['phone']])
Позвонить
@endcomponent

@endcomponent
