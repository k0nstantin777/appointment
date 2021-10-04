@component('mail::message')
    # Новый визит

    Создан новый визит в {{ config('app.name') }}

<p>Детали визита:</p>
<p>
    <strong> Дата:</strong> {{ $visit->visit_date->toDateString() }} <br>
    <strong> Время:</strong> {{ $visit->start_at->format('H:i') }} - {{ $visit->end_at->format('H:i') }} <br>
    <strong> Услуга:</strong> {{ $visit->service->name }} <br>
    <strong> Мастер:</strong> {{ $visit->employee->name }} <br>
    <strong> Клиент:</strong> {{ $visit->client->name }} <br>
    <strong> Цена:</strong> {{ $visit->price }} руб. <br>
</p>
@endcomponent

