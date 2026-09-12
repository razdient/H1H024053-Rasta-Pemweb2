@props(['sks'])

<span style="
    background-color: {{ $sks < 3 ? '#f8d7da' : '#d4edda' }};
    color: {{ $sks < 3 ? '#721c24' : '#155724' }};
    padding: 5px 10px;
    border-radius: 5px;
">
    {{ $sks }} SKS
</span>