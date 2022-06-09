<div>
    <div class="panel panel-body bg-{{ $color }}-400 has-bg-image">
        <div class="media no-margin">
            <div class="media-body">
                <h3 class="no-margin">
                    @if ($tipo == 'dinero')
                    $ {{ number_format($cantidad,2) }}
                    @else
                    {{ $cantidad }}
                    @endif
                </h3>
                <span class="text-uppercase h6">{{ $texto }}</span>
            </div>

            <div class="m-auto">
                <i class="fas fa-{{ $icon }} icon-3x opacity-80"></i>
            </div>
        </div>
    </div>
</div>
