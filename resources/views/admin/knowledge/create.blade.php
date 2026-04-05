<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <!-- CABECERA -->
        <div style="margin-bottom: 3rem; display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('admin.knowledge.index') }}" style="text-decoration: none; color: #94a3b8; font-size: 1.5rem; transition: 0.2s;" onmouseover="this.style.color='#111827'">←</a>
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px;">Redactar Nuevo Manual</h1>
                <p style="font-size: 0.85rem; color: #6b7280; font-weight: 500; margin-top: 0.4rem;">Documenta una nueva solución técnica para el personal.</p>
            </div>
        </div>

        <!-- FORMULARIO SAAS -->
        <div style="max-width: 1000px; background: white; border-radius: 1.8rem; border: 1px solid #e5e7eb; padding: 4rem; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            
            <form action="{{ route('admin.knowledge.store') }}" method="POST">
                @csrf
                
                <!-- TÍTULO -->
                <div style="margin-bottom: 3rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1.2rem; letter-spacing: 1.5px; text-transform: uppercase;">TÍTULO DEL MANUAL</label>
                    <input type="text" name="title" required placeholder="Ej: Cómo configurar el correo en Outlook" 
                           style="width: 100%; padding: 1.2rem 1.5rem; border-radius: 14px; border: 1.5px solid #e2e8f0; font-size: 1rem; font-weight: 600; outline: none; transition: 0.2s;" onfocus="this.style.border-color='#2563eb'">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem;">
                    <!-- CATEGORÍA -->
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1.2rem; letter-spacing: 1.5px; text-transform: uppercase;">CATEGORÍA</label>
                        <select style="width: 100%; padding: 1.2rem 1.5rem; border-radius: 14px; border: 1.5px solid #e2e8f0; background: white; font-weight: 600; outline: none; appearance: none; color: #1e293b;">
                            <option>Redes y Conectividad</option>
                            <option>Soporte de Hardware</option>
                            <option>Sistemas y Software</option>
                            <option>Seguridad Informática</option>
                        </select>
                    </div>
                    <!-- ICONO -->
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1.2rem; letter-spacing: 1.5px; text-transform: uppercase;">ICONO VISUAL</label>
                        <select name="icon" style="width: 100%; padding: 1.2rem 1.5rem; border-radius: 14px; border: 1.5px solid #e2e8f0; background: white; font-size: 1.2rem; outline: none;">
                            <option value="💻">💻 Computadora</option>
                            <option value="📡">📡 Red / Wi-Fi</option>
                            <option value="🔐">🔐 Seguridad</option>
                            <option value="🖨️">🖨️ Impresora</option>
                        </select>
                    </div>
                </div>

                <!-- CONTENIDO -->
                <div style="margin-bottom: 3.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1.2rem; letter-spacing: 1.5px; text-transform: uppercase;">CONTENIDO DEL MANUAL (INSTRUCCIONES)</label>
                    <textarea name="content" rows="12" required placeholder="Describe los pasos detalladamente..." 
                              style="width: 100%; padding: 1.8rem; border-radius: 18px; border: 1.5px solid #e2e8f0; font-family: inherit; font-size: 0.95rem; line-height: 1.8; resize: none; outline: none; transition: 0.2s;" onfocus="this.style.border-color='#2563eb'"></textarea>
                </div>

                <!-- BOTONES DE ACCIÓN -->
                <div style="display: flex; justify-content: flex-end; gap: 1.5rem; padding-top: 2.5rem; border-top: 1px solid #f1f5f9;">
                    <button type="button" onclick="window.history.back()" 
                            style="background: transparent; color: #94a3b8; border: none; font-size: 0.75rem; font-weight: 800; padding: 1rem 2rem; border-radius: 12px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='#111827'">DESCARTAR CAMBIOS</button>
                    <button type="submit" class="btn-primary" 
                            style="padding: 1.1rem 3.5rem; font-size: 0.8rem; border-radius: 14px; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);">PUBLICAR MANUAL ✅</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
