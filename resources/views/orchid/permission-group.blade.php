<div>
    @if(filled($title))
        <div class="form-label">{{ $title }}</div>
    @endif

    <div class="d-flex flex-wrap align-items-center column-gap-4 row-gap-2">
        @foreach($checkboxes as $checkbox)
            <div style="width: max-content; max-width: 100%;">
                {!! $checkbox !!}
            </div>
        @endforeach
    </div>
</div>
