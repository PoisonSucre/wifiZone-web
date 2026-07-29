@props(['type' => 'button'])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'flex-1 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-xs font-bold text-slate-600 dark:text-gray-400 hover:bg-slate-200 dark:hover:bg-darkBorder/50 transition-all']) }}>
    {{ $slot }}
</button>
