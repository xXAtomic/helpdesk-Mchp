<x-app-layout>
    <x-slot name="header">
        Mis Tickets 🔥
    </x-slot>

    <div class="py-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-gray-900 italic tracking-tight">HISTORIAL DE REQUERIMIENTOS 📋</h2>
            <a href="{{ route('user.tickets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-black text-xs shadow-lg shadow-blue-200 transition transform hover:-translate-y-1 uppercase tracking-wider">
                + NUEVO REQUERIMIENTO 🚀
            </a>
        </div>

        <!-- LISTADO DE TICKETS -->
        <div class="flex flex-col gap-4">
            @forelse($tickets as $ticket)
                <a href="{{ route('user.tickets.show', $ticket) }}" 
                   class="group flex items-center justify-between p-6 bg-white border-2 border-gray-100 rounded-[2rem] hover:border-blue-400 transition-all duration-300 shadow-sm hover:shadow-xl">
                    
                    <div class="flex items-center gap-6">
                        <!-- NUMERACIÓN -->
                        <div class="w-24 py-2 bg-gray-50 border border-gray-100 rounded-xl text-center font-black text-blue-600 text-[0.65rem] tracking-tighter">
                            #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                        </div>
                        
                        <div>
                            <h3 class="font-black text-lg text-gray-900 group-hover:text-blue-600 transition">{{ $ticket->title }}</h3>
                            <p class="text-[0.65rem] text-gray-400 font-bold mt-1 uppercase tracking-widest leading-none">
                                ENVIADO EL {{ $ticket->created_at->format('d/m/Y') }} • {{ $ticket->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="inline-block px-5 py-2 rounded-full text-[0.65rem] font-black uppercase tracking-widest border-2"
                              style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}30;">
                            {{ optional($ticket->status)->name ?? 'PENDIENTE' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-black text-lg italic mt-4 uppercase">AúN NO HAS REPORTADO NINGÚN TICKET ✨</p>
                    <a href="{{ route('user.tickets.create') }}" class="inline-block mt-6 text-blue-600 font-black text-xs hover:underline uppercase">Empieza reportando uno aquí →</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
