@component('mail::message')
# Новая заявка с сайта

**Имя:** {{ $data['name'] }}
**Телефон:** {{ $data['phone'] }}
@if (!empty($data['city']))
**Город:** {{ $data['city'] }}
@endif
**Товар:** {{ $data['product_name'] ?? 'Не указан' }}
@component('mail::button', ['url' => 'tel:' . $data['phone']])
Позвонить
@endcomponent
@endcomponent
