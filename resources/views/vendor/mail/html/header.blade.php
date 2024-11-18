<tr>
    <td class="header">
        <a href="{{ $url }}" style="display:block;">
            {{-- @if (trim($slot) === 'Laravel')
                <img src="{{ asset('/img/eventsdon.svg') }}" class="logo" alt="Laravel Logo">
            @else
                {{ $slot }}
            @endif --}}
            <img src="{{ asset('/img/eventsdon.png') }}" style="width: 350px" class="logo"
                alt="{{ config('app.name') }} Logo">
            <br>
        </a>
    </td>
</tr>
