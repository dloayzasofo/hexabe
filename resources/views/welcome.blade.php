<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HexaBE CRM Agencia</title>
  <style>
    :root {
      --bg: #071526;
      --surface: #0d2042;
      --surface-soft: #152d58;
      --accent: #f39c12;
      --accent-soft: #f7b76b;
      --text: #f1f5fb;
      --text-muted: #a9bbd8;
      --border: rgba(255,255,255,0.08);
      font-family: "Inter", system-ui, sans-serif;
      scroll-behavior: smooth;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background: radial-gradient(circle at top left, rgba(243,156,18,0.16), transparent 25%),
                  linear-gradient(180deg, #061123 0%, #081a30 100%);
      color: var(--text);
      min-height: 100vh;
    }

    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=60') center/cover no-repeat;
      opacity: .08;
      pointer-events: none;
      z-index: -1;
      filter: blur(8px);
    }

    header {
      width: 100%;
      padding: 28px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 10;
      background: rgba(7,21,38,.88);
      border-bottom: 1px solid rgba(255,255,255,.06);
      backdrop-filter: blur(12px);
    }

    .logo {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--text);
      font-size: 0.95rem;
    }

    .logo span {
      width: 14px;
      height: 14px;
      border-radius: 4px;
      background: linear-gradient(135deg, #f39c12, #ffc970);
      display: inline-block;
    }

    nav {
      display: flex;
      gap: 1.8rem;
      align-items: center;
      flex-wrap: wrap;
    }

    nav a {
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.95rem;
      transition: color .2s ease;
    }

    nav a:hover,
    nav a.active {
      color: var(--text);
    }

    .btn-primary {
      background: var(--accent);
      color: #08101e;
      border: none;
      border-radius: 999px;
      padding: 12px 24px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 18px 40px rgba(243,156,18,.18);
      transition: transform .2s ease, filter .2s ease;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      filter: brightness(1.02);
    }

    .hero {
      max-width: 1200px;
      margin: 0 auto;
      padding: 96px 32px 72px;
      display: grid;
      grid-template-columns: 1.1fr .9fr;
      gap: 48px;
      align-items: center;
    }

    .hero-copy h1 {
      font-size: clamp(2.8rem, 4vw, 4.4rem);
      line-height: 1.02;
      margin-bottom: 24px;
      letter-spacing: -.03em;
    }

    .hero-copy p {
      max-width: 570px;
      color: var(--text-muted);
      line-height: 1.8;
      font-size: 1rem;
      margin-bottom: 32px;
    }

    .hero-actions {
      display: flex;
      gap: 18px;
      flex-wrap: wrap;
    }

    .hero-card {
      background: rgba(4,13,29,.88);
      border: 1px solid rgba(255,255,255,.06);
      border-radius: 24px;
      padding: 28px;
      box-shadow: 0 24px 80px rgba(0,0,0,.28);
    }

    .hero-card h2 {
      margin-bottom: 18px;
      font-size: 1.25rem;
    }

    .hero-card ul {
      list-style: none;
      display: grid;
      gap: 16px;
    }

    .hero-card li {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      color: var(--text-muted);
      line-height: 1.7;
    }

    .hero-card li::before {
      content: "\2713";
      color: var(--accent);
      margin-top: 3px;
      font-size: 0.95rem;
    }

    .hero-visual {
      display: grid;
      gap: 22px;
      align-items: end;
    }

    .visual-panel {
      background: linear-gradient(135deg, rgba(9,30,58,.96), rgba(13,31,65,.98));
      border: 1px solid rgba(255,255,255,.08);
      border-radius: 30px;
      padding: 28px;
      overflow: hidden;
    }

    .visual-panel p {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-bottom: 18px;
    }

    .progress-bar {
      position: relative;
      height: 14px;
      background: rgba(255,255,255,.04);
      border-radius: 999px;
      overflow: hidden;
    }

    .progress-bar span {
      display: block;
      height: 100%;
      width: 75%;
      background: linear-gradient(90deg, #f39c12, #ffc970);
      border-radius: inherit;
      transition: width .6s ease;
    }

    .grid-features {
      max-width: 1100px;
      margin: 0 auto;
      padding: 32px 32px 64px;
      display: grid;
      gap: 24px;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    }

    .feature-card {
      background: rgba(255,255,255,.04);
      border: 1px solid rgba(255,255,255,.08);
      padding: 28px;
      border-radius: 24px;
      min-height: 220px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .feature-card h3 {
      margin-bottom: 16px;
      font-size: 1.15rem;
    }

    .feature-card p {
      color: var(--text-muted);
      line-height: 1.75;
      flex: 1;
    }

    .feature-icon {
      width: 46px;
      height: 46px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 16px;
      background: rgba(243,156,18,.12);
      color: var(--accent);
      font-size: 1.1rem;
      margin-bottom: 18px;
    }

    .section-cta {
      background: rgba(11,24,45,.92);
      margin: 0 32px 64px;
      padding: 44px 40px;
      border-radius: 28px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 24px;
    }

    .section-cta h2 {
      font-size: clamp(1.8rem, 2.2vw, 2.6rem);
      margin-bottom: 12px;
    }

    .footer {
      text-align: center;
      padding: 24px 32px 48px;
      color: var(--text-muted);
      font-size: 0.95rem;
    }

    .testimonial {
      background: rgba(255,255,255,.03);
      border: 1px solid rgba(255,255,255,.08);
      border-radius: 24px;
      padding: 28px;
      display: grid;
      gap: 14px;
      max-width: 1100px;
      margin: 0 auto 64px;
    }

    .testimonial p {
      line-height: 1.9;
      color: var(--text-muted);
    }

    .testimonial-footer {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .testimonial-avatar {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: linear-gradient(135deg, #f39c12, #ffc970);
      display: grid;
      place-items: center;
      color: #08101e;
      font-weight: 700;
    }

    .testimonial-info h4,
    .testimonial-info span {
      color: var(--text);
    }

    @media (max-width: 900px) {
      .hero {
        grid-template-columns: 1fr;
        padding-top: 72px;
      }

      header {
        flex-direction: column;
        align-items: flex-start;
      }

      nav {
        width: 100%;
        justify-content: space-between;
      }
    }

    @media (max-width: 680px) {
      .hero {
        padding: 64px 20px 48px;
      }

      .section-cta,
      .hero-card,
      .visual-panel,
      .feature-card,
      .testimonial {
        margin: 0;
      }
    }
  </style>
</head>
<body>
  <header>
    <a class="logo" href="#">
      <span></span>
      HexaBE CRM
    </a>
    <nav>
      <a href="#soluciones" class="active">Soluciones</a>
      <a href="#beneficios">Beneficios</a>
      <a href="#testimonios">Testimonios</a>
      <a href="#contacto">Contacto</a>
    </nav>
    <a href="{{ route('login') }}" class="btn-primary" style="text-decoration:none;">Ingresar</a>
  </header>

  <main>
    <section class="hero" id="inicio">
      <div class="hero-copy">
        <p style="text-transform: uppercase; letter-spacing: .22em; color: #f39c12; font-size: .9rem; margin-bottom: 18px;">CRM para agencias que mueven campañas</p>
        <h1>Gestiona tareas, clientes y creatividad desde un solo tablero.</h1>
        <p>HexaBE CRM fue creado para equipos de publicidad que necesitan organizar briefs, planificar entregas y sincronizar el trabajo creativo con la ejecución de campañas.</p>
        <div class="hero-actions">
          <button class="btn-primary" onclick="scrollToSection('soluciones')">Descubre cómo</button>
          <a href="#contacto" style="color: var(--text); align-self: center; text-decoration: none; font-weight: 600;">Ver demo rápida</a>
        </div>
      </div>

      <aside class="hero-visual">
        <div class="visual-panel">
          <p>Pipeline de proyectos</p>
          <div class="progress-bar"><span></span></div>
          <p style="margin-top: 22px; color: var(--text);">80% de campañas entregadas a tiempo con coordinación centralizada.</p>
        </div>
        <div class="hero-card">
          <h2>Funcionalidades clave</h2>
          <ul>
            <li>Control total de briefs y aprobaciones.</li>
            <li>Asignación inteligente de tareas por especialista.</li>
            <li>Panel en tiempo real para clientes y creativos.</li>
          </ul>
        </div>
      </aside>
    </section>

    <section class="grid-features" id="soluciones">
      <article class="feature-card">
        <div>
          <div class="feature-icon">📋</div>
          <h3>Planificación de tareas</h3>
          <p>Crea flujos de trabajo adaptados a cada cliente, con milestones visibles y recordatorios automáticos para cada etapa del proyecto.</p>
        </div>
      </article>
      <article class="feature-card">
        <div>
          <div class="feature-icon">🤝</div>
          <h3>Colaboración en equipo</h3>
          <p>Comparte briefs, revisiones y archivos en un espacio seguro donde todos los equipos —creativos, cuentas y clientes— trabajan sincronizados.</p>
        </div>
      </article>
      <article class="feature-card">
        <div>
          <div class="feature-icon">🚀</div>
          <h3>Entrega optimizada</h3>
          <p>Controla fechas de entrega, tareas pendientes y resultados con métricas claras para acelerar cada campaña.</p>
        </div>
      </article>
      <article class="feature-card">
        <div>
          <div class="feature-icon">📊</div>
          <h3>Reporting estratégico</h3>
          <p>Genera insights de rendimiento y eficiencia en minutos para demostrar el valor de la agencia en cada presentación.</p>
        </div>
      </article>
    </section>

    <section class="testimonial" id="testimonios">
      <p>“HexaBE transformó la forma en que coordinamos tareas entre cuentas y producción. Ahora los plazos se cumplen, las revisiones se gestionan sin sobresaltos y nuestro equipo creativo gana tiempo para lo que importa.”</p>
      <div class="testimonial-footer">
        <div class="testimonial-avatar">PB</div>
        <div class="testimonial-info">
          <h4>Pilar Benítez</h4>
          <span>Directora de Cuentas, Agencia Nova</span>
        </div>
      </div>
    </section>

    <section class="section-cta" id="beneficios">
      <div>
        <h2>Un CRM diseñado para talento creativo y equipos de alto crecimiento.</h2>
        <p>Reduce tiempos de entrega, mejora la comunicación y entrega información clara a cada cliente con un sistema corporativo elegante y potente.</p>
      </div>
      <button class="btn-primary" onclick="scrollToSection('contacto')">Quiero una demo</button>
    </section>

    <section id="contacto" style="max-width: 960px; margin: 0 auto 64px; padding: 0 32px;">
      <div style="background: rgba(4,13,29,.92); border: 1px solid rgba(255,255,255,.08); border-radius: 30px; padding: 36px;">
        <h2 style="margin-bottom: 18px;">Comienza con tu equipo</h2>
        <p style="margin-bottom: 28px; color: var(--text-muted);">Solicita una demostración y descubre cómo HexaBE CRM puede impulsar tu próxima campaña.</p>
        <form onsubmit="sendDemoRequest(event)" style="display:grid; gap:18px;">
          <div style="display:grid; gap:14px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
            <input type="text" id="name" placeholder="Nombre completo" required style="padding:16px 18px; border-radius: 16px; border: 1px solid rgba(255,255,255,.1); background: rgba(255,255,255,.04); color: var(--text); outline:none;">
            <input type="email" id="email" placeholder="Correo electrónico" required style="padding:16px 18px; border-radius: 16px; border: 1px solid rgba(255,255,255,.1); background: rgba(255,255,255,.04); color: var(--text); outline:none;">
          </div>
          <textarea id="message" rows="4" placeholder="Cuéntanos sobre tu agencia" style="padding:16px 18px; border-radius: 16px; border: 1px solid rgba(255,255,255,.1); background: rgba(255,255,255,.04); color: var(--text); outline:none;"></textarea>
          <div style="display:flex; flex-wrap: wrap; gap: 14px; align-items:center; justify-content: space-between;">
            <button class="btn-primary" type="submit">Enviar solicitud</button>
            <span id="contact-status" style="color: var(--accent-soft); font-size: .95rem;"></span>
          </div>
        </form>
      </div>
    </section>
  </main>

  <footer class="footer">
    © 2026 HexaBE CRM · Gestión de campañas y tareas para agencias de publicidad.
  </footer>

  <script>
    function scrollToSection(id) {
      document.getElementById(id).scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function sendDemoRequest(event) {
      event.preventDefault();
      const status = document.getElementById('contact-status');
      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const message = document.getElementById('message').value.trim();

      if (!name || !email || !message) {
        status.textContent = 'Completa todos los campos para continuar.';
        return;
      }

      status.textContent = 'Solicitud enviada. Nos contactamos pronto.';
      event.target.reset();
    }
  </script>
</body>
</html>
