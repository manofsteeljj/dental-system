<button {{ $attributes->merge(['type' => 'submit', 'class' => 'dental-button']) }}>
    {{ $slot }}
</button>
