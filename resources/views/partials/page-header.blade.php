<div class="page-hero {{ $heroClass ?? '' }}">
    <h1 class="h3">{{ $title }}</h1>
    @if(!empty($subtitle))
        <p>{{ $subtitle }}</p>
    @endif
</div>
