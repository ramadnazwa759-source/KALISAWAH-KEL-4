@props(['name', 'instansi', 'review', 'image', 'rating' => 5])

<div class="bg-white p-8 rounded-3xl shadow-lg relative pt-12 flex flex-col h-full group hover:-translate-y-2 transition-all duration-300">
    <div class="absolute -top-6 left-8 w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-xl">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
    </div>
    <div class="text-secondary text-5xl font-serif absolute top-4 right-8 opacity-20 group-hover:opacity-40 transition-opacity">"</div>
    
    <div class="flex gap-1 mb-4">
        @for($i=0; $i<$rating; $i++)
            <i class="fa-solid fa-star text-secondary text-xs"></i>
        @endfor
    </div>
    
    <p class="text-gray-500 text-sm italic mb-8 leading-relaxed flex-grow">
        "{{ $review }}"
    </p>
    
    <div class="mt-auto pt-6 border-t border-gray-50">
        <h4 class="font-bold text-dark-navy group-hover:text-primary transition-colors">{{ $name }}</h4>
        <p class="text-secondary text-xs font-bold uppercase tracking-wider mt-1">{{ $instansi }}</p>
    </div>
</div>
