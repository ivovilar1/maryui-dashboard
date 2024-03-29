<div>
    @foreach($this->customers as $customer)
        <li> {{ $customer->name }}</li>
    @endforeach
</div>
