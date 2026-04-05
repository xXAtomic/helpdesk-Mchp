<x-app-layout>
    <x-slot name="header">
        Detalle del Ticket #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
    </x-slot>

    <div class="py-6 space-y-8">
        <!-- CABECERA DEL TICKET -->
        <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-4 py-1 rounded-full text-[0.6rem] font-black uppercase tracking-widest border-2"
                          style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}30;">
                        🚀 {{ optional($ticket->status)->name ?? 'EN PROCESO' }}
                    </span>
                    <span class="text-[0.65rem] font-black text-gray-300 uppercase tracking-widest">
                        CATEGORÍA: {{ optional($ticket->category)->name ?? 'GENERAL' }}
                    </span>
                </div>
                <h2 class="text-2xl font-black text-gray-900 italic uppercase tracking-tighter">{{ $ticket->title }}</h2>
            </div>
            <a href="{{ route('user.tickets.index') }}" class="text-[0.7rem] font-black text-gray-400 hover:text-blue-600 transition uppercase tracking-widest flex items-center gap-2">
                ← VOLVER AL LISTADO
            </a>
        </div>

        <!-- HISTORIAL DE MENSAJES (TIMELINE) -->
        <div class="flex flex-col gap-6">
            <!-- MENSAJE ORIGINAL -->
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-black text-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-black text-gray-900 text-sm uppercase tracking-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[0.6rem] text-gray-400 font-bold uppercase">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <span class="text-[0.6rem] font-black text-blue-400 uppercase tracking-widest">SOLICITUD INICIAL</span>
                </div>
                <div class="text-sm font-medium text-gray-600 leading-relaxed">
                    {!! nl2br(e($ticket->description)) !!}
                </div>
            </div>

            <!-- RESPUESTAS -->
            @foreach($ticket->replies as $reply)
                <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100 relative overflow-hidden {{ ($reply->user->role_id ?? 1) != 3 ? 'ml-0 md:ml-12 border-blue-200 bg-blue-50/30' : '' }}">
                    @if(($reply->user->role_id ?? 1) != 3)
                        <div class="absolute top-0 left-0 w-2 h-full bg-amber-400"></div>
                    @endif
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full {{ ($reply->user->role_id ?? 1) != 3 ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-600' }} flex items-center justify-center font-black text-xs">
                                {{ substr($reply->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-black text-gray-900 text-sm uppercase tracking-tight">
                                    {{ $reply->user->name }}
                                    @if(($reply->user->role_id ?? 1) != 3)
                                        <span class="ml-2 text-[0.55rem] bg-amber-400 text-white px-2 py-0.5 rounded-lg tracking-widest font-black uppercase">SOPORTE TI</span>
                                    @endif
                                </p>
                                <p class="text-[0.6rem] text-gray-400 font-bold uppercase">{{ $reply->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-gray-600 leading-relaxed">
                        {!! nl2br(e($reply->body)) !!}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- FORMULARIO DE RESPUESTA -->
        @if(!optional($ticket->status)->is_closed)
            <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-gray-100">
                <h4 class="text-lg font-black text-gray-900 mb-8 italic uppercase tracking-tighter">AñADIR RESPUESTA 📥</h4>
                <form action="{{ route('user.tickets.reply', $ticket) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea name="body" required rows="4" placeholder="ESCRIBE AQUÍ TU MENSAJE..."
                              class="w-full px-8 py-6 rounded-[2rem] bg-gray-50 border-2 border-gray-100 font-bold text-sm focus:border-blue-500 focus:bg-white transition outline-none placeholder:text-gray-300 mb-6"></textarea>
                    
                    <div class="mb-8">
                        <label class="text-[0.6rem] font-black text-gray-450 uppercase tracking-widest mb-3 block">ADJUNTAR MÁS EVIDENCIA (OPCIONAL)</label>
                        <input type="file" name="attachments[]" multiple
                               class="w-full px-6 py-4 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 text-gray-400 font-black text-[0.65rem] cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition uppercase">
                    </div>

                    <button type="submit" class="w-full md:w-auto px-12 py-5 rounded-2xl bg-blue-600 text-white font-black text-sm shadow-xl shadow-blue-200 hover:bg-blue-700 transition uppercase tracking-widest">
                        ENVIAR RESPUESTA 📤
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gray-100 p-8 rounded-[3rem] text-center">
                <p class="text-gray-500 font-black text-xs uppercase tracking-widest">ESTE TICKET ESTá CERRADO Y NO ADMITE MáS RESPUESTAS. ✨</p>
            </div>
        @endif
    </div>
</x-app-layout>
