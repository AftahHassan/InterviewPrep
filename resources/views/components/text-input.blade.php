@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-600 bg-slate-700 text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
