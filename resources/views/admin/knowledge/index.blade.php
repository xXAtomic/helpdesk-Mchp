<x-app-layout>
    <div style="display: flex; height: 100vh; background: #fdfdfd; overflow: hidden;">

        <!-- 🟦 LADO IZQUIERDO: CONTENIDO PRINCIPAL -->
        <div style="flex: 1; padding: 4rem 3.5rem; overflow-y: auto; border-right: 1px solid #f1f5f9;">
            <div style="margin-bottom: 4rem;">
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827; letter-spacing: -0.5px;">Portal de Soporte Técnico</h1>
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <input type="text" placeholder="🔍 Buscar solución..." style="flex: 1; padding: 0.9rem 1.5rem; border-radius: 12px; border: 1.5px solid #e5e7eb; outline: none; font-weight: 500; transition: 0.2s;" onfocus="this.style.border-color='#3b82f6'">
                    <button class="btn-primary" style="padding: 0.9rem 2.2rem; border-radius: 12px; font-weight: 700;" onclick="window.location.href='{{ route('admin.knowledge.create') }}'">+ CREAR MANUAL</button>
                </div>
            </div>

            <h3 style="font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 2rem;">Manuales Registrados</h3>

            <!-- GRID DE TARJETAS -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
                @forelse(\App\Models\KnowledgeBase::orderBy('created_at', 'desc')->get() as $m)
                    <div class="manual-card" style="background: white; padding: 2.2rem; border-radius: 2rem; border: 1px solid #f1f5f9; box-shadow: 0 4px 25px rgba(0,0,0,0.02); transition: 0.3s; cursor: pointer; position: relative; overflow: hidden;">
                        
                        <!-- 🛠️ BOTONES DE ACCIÓN (ESQUINA SUPERIOR DERECHA) -->
                        <div style="position: absolute; top: 1.2rem; right: 1.2rem; display: flex; gap: 0.5rem; z-index: 20;">
                            <!-- EDITAR (Lápiz) -->
                            <a href="{{ route('admin.knowledge.edit', $m->id) }}" title="Editar" 
                               style="width: 32px; height: 32px; background: #eff6ff; color: #2563eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.9rem; transition: 0.2s;">
                               ✏️
                            </a>
                            <!-- ELIMINAR (X) -->
                            <form action="{{ route('admin.knowledge.destroy', $m->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este manual para siempre?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Eliminar" 
                                        style="width: 32px; height: 32px; background: #fef2f2; color: #ef4444; border: none; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem; transition: 0.2s;">
                                ❌
                                </button>
                            </form>
                        </div>

                        <!-- CONTENIDO (CLIC ABRE MODAL) -->
                        <div onclick="abrirModal('{{ $m->title }}', '{{ str_replace(["\r", "\n"], ' ', addslashes($m->content)) }}')">
                            <div style="font-size: 1.8rem; margin-bottom: 1.5rem;">{{ $m->icon }}</div>
                            <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #111827; padding-right: 3rem;">{{ $m->title }}</h4>
                            <p style="margin-top: 0.8rem; color: #64748b; font-size: 0.8rem; font-weight: 500;">Haz clic para visualizar detalles...</p>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; color: #94a3b8; font-weight: 600; padding: 5rem;">Todavía no hay manuales publicados. 🗒️</div>
                @endforelse
            </div>
        </div>

        <!-- ⬛ LADO DERECHO: SIDEBAR AGENTE -->
        <div style="width: 380px; background: #fafafa; padding: 4rem 2.5rem;">
            <div style="background: #111827; padding: 2.2rem; border-radius: 2rem; color: white; margin-bottom: 3rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 1.5rem;">
                    <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 10px #10b981;"></div>
                    <span style="font-weight: 800; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Soporte Inteligente ACTIVO</span>
                </div>
                <p style="font-size: 0.85rem; color: #9ca3af; line-height: 1.6; margin-bottom: 1.8rem;">¿Necesitas que todos vean una recomendación importante de inmediato?</p>
                <button class="btn-primary" style="width: 100%; padding: 1rem; border-radius: 12px;" onclick="alert('🚀 Notificación enviada!')">ENVIAR A TODOS ✅</button>
            </div>
        </div>

    </div>

    <!-- 🚀 MODAL DE VISUALIZACIÓN -->
    <div id="modalManual" style="display: none; position: fixed; top:0; left:0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); backdrop-filter: blur(10px); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; width: 600px; padding: 3.5rem; border-radius: 2.5rem; box-shadow: 0 50px 100px rgba(0,0,0,0.4); position: relative;">
            <h2 id="modalTitulo" style="font-size: 1.6rem; font-weight: 800; color: #111827; margin-bottom: 1.5rem;"></h2>
            <div id="modalContenido" style="font-size: 0.95rem; color: #4b5563; line-height: 1.8; background: #f9fafb; padding: 2rem; border-radius: 1.5rem; border: 1px solid #f1f5f9; white-space: pre-line; max-height: 400px; overflow-y: auto;"></div>
            <button onclick="cerrarModal()" class="btn-primary" style="margin-top: 2.5rem; width: 100%; padding: 1.2rem; border-radius: 15px;">ENTENDIDO, CERRAR</button>
        </div>
    </div>

    <script>
        function abrirModal(t, c) {
            document.getElementById('modalTitulo').innerText = t;
            document.getElementById('modalContenido').innerText = c;
            document.getElementById('modalManual').style.display = 'flex';
        }
        function cerrarModal() {
            document.getElementById('modalManual').style.display = 'none';
        }
    </script>
</x-app-layout>
