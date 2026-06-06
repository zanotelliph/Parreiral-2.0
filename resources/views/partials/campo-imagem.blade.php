@php
    $inputName = $inputName ?? 'imagem';
    $previewId = $previewId ?? 'preview-imagem';
    $imagemAtual = $imagemAtual ?? null;
    $label = $label ?? 'Imagem';
    $urlAtual = $imagemAtual ? asset('storage/' . $imagemAtual) : asset('images/sem-imagem.svg');
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $inputName }}">{{ $label }}</label>
    <div class="mb-2">
        <img
            id="{{ $previewId }}"
            src="{{ $urlAtual }}"
            alt="Pré-visualização"
            class="img-thumbnail object-fit-cover"
            style="width: 200px; height: 200px; object-fit: cover;"
        >
    </div>
    <input
        type="file"
        id="{{ $inputName }}"
        name="{{ $inputName }}"
        class="form-control"
        accept="image/png,image/jpeg,image/jpg"
        onchange="previewImagem(this, '{{ $previewId }}')"
    >
    <div class="form-text">Formatos aceitos: PNG, JPG ou JPEG.</div>
</div>
