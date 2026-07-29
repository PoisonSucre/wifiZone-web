@props(['label' => '', 'placeholder' => '', 'type' => 'text', 'model' => '', 'required' => false, 'min' => null, 'step' => null])
<div>
    @if($label)
        <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">{{ $label }}</label>
    @endif
    <input type="{{ $type }}"
           @if($model) wire:model="{{ $model }}" @endif
           placeholder="{{ $placeholder }}"
           @if($required) required @endif
           @if($min !== null) min="{{ $min }}" @endif
           @if($step !== null) step="{{ $step }}" @endif
           {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200']) }}>
</div>
