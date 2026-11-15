@php
    // ✏️ EDITE AQUI: todos os dados da página ficam neste bloco.
    $escola = [
        'nome'      => 'Colégio Apollinho',
        'instagram' => 'colegio.apollinho',
        'whatsapp'  => '5571993556919',      // DDI + DDD + número, só dígitos
        'telefone'  => '(71) 9 9355-6919',
        'email'     => '',                    // opcional: se vazio, não aparece
        'endereco'  => '',                    // ✏️ PREENCHA com o endereço da escola (se vazio, não aparece)
        'horario'   => 'Turno integral',
        'niveis'    => 'Berçário ao G5',
    ];

    $etapas = [
        ['titulo' => 'Berçário', 'idade' => 'Os primeiros passos', 'texto' => 'Cuidado, carinho e estímulos para os bebês no ritmo de cada um.', 'cor' => 'sol'],
        ['titulo' => 'G1 e G2', 'idade' => 'Descobertas', 'texto' => 'Brincadeiras, música e exploração para conhecer o mundo ao redor.', 'cor' => 'laranja'],
        ['titulo' => 'G3, G4 e G5', 'idade' => 'Aprender brincando', 'texto' => 'Linguagem, números e convivência, com preparação para o Fundamental.', 'cor' => 'mel'],
    ];

    $diferenciais = [
        'Turmas acolhedoras, com acompanhamento próximo',
        'Parceria constante entre escola e família',
        'Atividades culturais, esportivas e de convivência',
        'Equipe pedagógica dedicada ao desenvolvimento de cada criança',
    ];

    $posts = [
        ['legenda' => 'Atividades em sala', 'cor' => 'sol',   'icone' => '✏️'],
        ['legenda' => 'Eventos e festas',    'cor' => 'pessego', 'icone' => '🎈'],
        ['legenda' => 'Hora do recreio',     'cor' => 'laranja',   'icone' => '⚽'],
        ['legenda' => 'Projetos da turma',   'cor' => 'mel', 'icone' => '🎨'],
        ['legenda' => 'Avisos e recados',    'cor' => 'sol',   'icone' => '📣'],
        ['legenda' => 'Momentos especiais',  'cor' => 'pessego', 'icone' => '⭐'],
    ];

    // 📷 Fotos do carrossel: basta colocar as imagens em public/images/carrossel/
    // Elas aparecem sozinhas, sem limite de quantidade, em ordem alfabética/numérica
    // (foto-1.jpg, foto-2.jpg, ... foto-10.jpg). Formatos: jpg, jpeg, png, webp.
    // Tamanho ideal: 1448 × 1086 px (proporção 4:3).
    $descricoes = [
        // 'foto-1.jpg' => 'Sala de aula do Grupo 3, com mesas e cadeiras coloridas',
    ];

    $arquivos = glob(public_path('images/carrossel/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}'), GLOB_BRACE) ?: [];
    natcasesort($arquivos);

    $fotos = array_map(fn ($caminho) => [
        'arquivo' => basename($caminho),
        'alt'     => $descricoes[basename($caminho)] ?? 'Foto do ' . $escola['nome'],
    ], array_values($arquivos));

    // Sem nenhuma foto na pasta ainda: mostra 3 espaços reservados.
    if (empty($fotos)) {
        $fotos = array_map(fn ($n) => ['arquivo' => "foto-$n.jpg", 'alt' => "Foto $n"], [1, 2, 3]);
    }

    $temLogo = file_exists(public_path('images/logo-sol.png'));

    $urlInstagram = 'https://www.instagram.com/' . $escola['instagram'] . '/';
    $urlWhatsapp  = 'https://wa.me/' . $escola['whatsapp'] . '?text=' . rawurlencode('Olá! Gostaria de saber mais sobre a matrícula no ' . $escola['nome'] . '.');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $escola['nome'] }} – {{ $escola['niveis'] }} | {{ $escola['horario'] }}</title>
    @if ($temLogo)
        <link rel="icon" type="image/png" href="{{ asset('images/logo-sol.png') }}">
    @endif
    <meta name="description" content="Conheça o {{ $escola['nome'] }}: etapas de ensino, rotina e como fazer a matrícula.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            color-scheme: light;
        }
        :root {
            --sol: #ffc72c;
            --sol-claro: #ffe27a;
            --laranja: #ff7a1a;
            --laranja-texto: #c2410c;
            --laranja-claro: #ffd9b8;
            --pessego: #ffa45c;
            --pessego-claro: #ffe8d2;
            --mel: #ffd84d;
            --mel-claro: #fff3b0;
            --borda: #ff8a2a;
            --tinta: #3d3a45;
            --tinta-suave: #66606f;
            --fundo: #fffdf6;
            --raio: 22px;
            --titulo: "Baloo 2", "Trebuchet MS", system-ui, sans-serif;
            --texto: "Nunito", "Segoe UI", system-ui, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: var(--fundo);
            color: var(--tinta);
            font-family: var(--texto);
            font-size: 1.05rem;
            line-height: 1.65;
        }
        img, svg { max-width: 100%; }
        a { color: inherit; }
        :focus-visible { outline: 3px solid var(--laranja-texto); outline-offset: 3px; border-radius: 6px; }

        h1, h2, h3 { font-family: var(--titulo); line-height: 1.1; margin: 0; color: var(--laranja-texto); }
        h2 { font-size: clamp(1.9rem, 4vw, 2.7rem); font-weight: 800; }
        h3 { font-size: 1.35rem; font-weight: 700; }
        p { margin: 0; }

        .container { width: min(1120px, 100% - 2.5rem); margin-inline: auto; }
        section { padding: 5rem 0; }

        /* ---------- Botões ---------- */
        .botao {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .85rem 1.5rem;
            border-radius: 999px;
            font-family: var(--titulo); font-weight: 700; font-size: 1.1rem;
            text-decoration: none;
            border: 3px solid var(--borda);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .botao:hover { transform: translateY(-2px); }
        .botao--principal { background: var(--sol); color: #3d3a45; box-shadow: 0 5px 0 #e8590c; }
        .botao--principal:hover { box-shadow: 0 7px 0 #e8590c; }
        .botao--contorno { background: transparent; color: var(--tinta); }

        /* ---------- Topo ---------- */
        .topo { position: sticky; top: 0; z-index: 10; background: var(--fundo); border-bottom: 3px solid var(--borda); }
        .topo__interno { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: .7rem 0; }
        .marca { color: var(--laranja-texto); display: flex; align-items: center; gap: .6rem; text-decoration: none; font-family: var(--titulo); font-weight: 800; font-size: 1.35rem; }
        .marca__logo { height: 36px; width: auto; display: block; }
        .marca__sol { width: 34px; height: 34px; border-radius: 50%; background: var(--sol); border: 3px solid var(--borda); }
        .menu { display: flex; gap: 1.4rem; align-items: center; }
        .menu a { text-decoration: none; font-weight: 700; }
        .menu a:hover { text-decoration: underline; text-decoration-thickness: 3px; text-decoration-color: var(--sol); text-underline-offset: 6px; }
        @media (max-width: 760px) { .menu a:not(.botao) { display: none; } }

        /* ---------- Início ---------- */
        .inicio { padding: 4rem 0 3rem; overflow: hidden; }
        .onda { display: block; width: 100%; height: clamp(40px, 7vw, 90px); background: var(--fundo); }
        .inicio__grade { display: grid; grid-template-columns: 1.1fr .9fr; gap: 3rem; align-items: center; }
        .inicio h1 { font-size: clamp(2.8rem, 8vw, 5.6rem); font-weight: 800; letter-spacing: -.01em; }
        .inicio h1 span { display: block; }
        .inicio h1 .pequeno { font-size: .42em; font-weight: 700; color: var(--tinta); margin-bottom: .3rem; }
        .inicio p.lead { max-width: 46ch; margin: 1.4rem 0 1.2rem; font-size: 1.2rem; color: var(--tinta-suave); }
        .inicio__acoes { display: flex; flex-wrap: wrap; gap: 1rem; }

        .chips { list-style: none; display: flex; flex-wrap: wrap; gap: .6rem; margin: 0 0 2rem; padding: 0; }
        .chips li { background: var(--mel); border: 3px solid var(--borda); border-radius: 999px; padding: .3rem 1.1rem; font-family: var(--titulo); font-weight: 700; font-size: 1.1rem; }
        .sol-logo { width: min(460px, 100%); height: auto; display: block; margin-inline: auto; }
        .sol-ilustracao { position: relative; aspect-ratio: 1; width: min(420px, 100%); margin-inline: auto; }
        .sol-ilustracao__raios { position: absolute; inset: 0; animation: girar 40s linear infinite; }
        .sol-ilustracao__miolo {
            position: absolute; inset: 22%;
            border-radius: 50%; background: var(--sol); border: 5px solid var(--borda);
            display: grid; place-items: center;
        }
        .rosto { width: 62%; }
        @keyframes girar { to { transform: rotate(360deg); } }
        @media (prefers-reduced-motion: reduce) { .sol-ilustracao__raios { animation: none; } html { scroll-behavior: auto; } }
        @media (max-width: 860px) {
            .inicio__grade { grid-template-columns: 1fr; }
            .sol-ilustracao, .sol-logo { order: -1; width: min(280px, 70%); }
        }

        /* ---------- Sobre ---------- */
        .sobre { background: var(--laranja-claro); border-bottom: 3px solid var(--borda); }
        .sobre__grade { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start; }
        .sobre p { color: var(--tinta-suave); margin-top: 1rem; max-width: 52ch; }
        .lista { list-style: none; margin: 0; padding: 0; display: grid; gap: .9rem; }
        .lista li { display: flex; gap: .8rem; align-items: flex-start; background: var(--fundo); border: 3px solid var(--borda); border-radius: 16px; padding: .9rem 1.1rem; font-weight: 600; }
        .lista li::before { content: ""; flex: none; width: 14px; height: 14px; margin-top: .5rem; border-radius: 50%; background: var(--mel); border: 2px solid var(--borda); }
        @media (max-width: 860px) { .sobre__grade { grid-template-columns: 1fr; } }


        /* ---------- Carrossel ---------- */
        .galeria { background: var(--mel-claro); border-block: 3px solid var(--borda); }
        .galeria__cabeca { max-width: 56ch; margin-bottom: 2rem; }
        .galeria__cabeca p { margin-top: .8rem; color: var(--tinta-suave); }
        .carrossel { position: relative; max-width: 900px; margin-inline: auto; }
        .carrossel__pista {
            display: flex; overflow-x: auto; scroll-snap-type: x mandatory;
            scrollbar-width: none; border: 3px solid var(--borda); border-radius: 28px; background: var(--fundo);
        }
        .carrossel__pista::-webkit-scrollbar { display: none; }
        .carrossel__slide { flex: 0 0 100%; scroll-snap-align: center; aspect-ratio: 1448 / 1086; margin: 0; position: relative; }
        .carrossel__slide img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .carrossel__vazio {
            width: 100%; height: 100%; display: grid; place-content: center; text-align: center; gap: .3rem;
            background: repeating-linear-gradient(45deg, var(--sol-claro) 0 18px, var(--pessego-claro) 18px 36px);
            font-family: var(--titulo); font-weight: 700; font-size: 1.3rem;
        }
        .carrossel__vazio small { font-family: var(--texto); font-weight: 600; font-size: .95rem; color: var(--tinta-suave); }
        .carrossel__botao {
            position: absolute; top: 50%; translate: 0 -50%; z-index: 2;
            width: 52px; height: 52px; border-radius: 50%; cursor: pointer;
            background: var(--sol); color: #3d3a45; border: 3px solid var(--borda);
            font-size: 1.5rem; font-weight: 800; line-height: 1; box-shadow: 0 4px 0 #e8590c;
        }
        .carrossel__botao:hover { background: var(--pessego); }
        .carrossel__botao--ant { left: -14px; }
        .carrossel__botao--prox { right: -14px; }
        .carrossel__pontos { display: flex; justify-content: center; gap: .6rem; margin-top: 1.2rem; }
        .carrossel__ponto { width: 16px; height: 16px; border-radius: 50%; border: 3px solid var(--borda); background: transparent; cursor: pointer; padding: 0; }
        .carrossel__ponto[aria-current="true"] { background: var(--laranja); }
        @media (max-width: 560px) { .carrossel__botao--ant { left: 6px; } .carrossel__botao--prox { right: 6px; } .carrossel__botao { width: 44px; height: 44px; } }

        /* ---------- Etapas ---------- */
        .etapas__cabeca { max-width: 56ch; margin-bottom: 2.5rem; }
        .etapas__cabeca p { margin-top: .8rem; color: var(--tinta-suave); }
        .etapas__grade { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }
        .etapa { border: 3px solid var(--borda); padding: 1.7rem; display: grid; gap: .6rem; align-content: start; }
        .etapa:nth-child(1) { border-radius: 40px 16px 16px 16px; }
        .etapa:nth-child(2) { border-radius: 16px 40px 16px 16px; }
        .etapa:nth-child(3) { border-radius: 16px 16px 40px 16px; }
        .etapa small { font-weight: 700; color: var(--tinta-suave); }
        .cor-sol   { background: var(--sol-claro); }
        .cor-laranja   { background: var(--laranja-claro); }
        .cor-mel { background: var(--mel-claro); }
        .cor-pessego { background: var(--pessego-claro); }

        /* ---------- Instagram ---------- */
        .insta { background: var(--sol); border-block: 3px solid var(--borda); }
        .insta__cabeca { display: flex; flex-wrap: wrap; align-items: end; justify-content: space-between; gap: 1.2rem; margin-bottom: 2rem; }
        .insta__cabeca p { color: var(--tinta-suave); margin-top: .6rem; }
        .insta__grade { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        .post {
            aspect-ratio: 1; border: 3px solid var(--borda); border-radius: 18px;
            display: grid; place-items: center; align-content: center; gap: .4rem;
            text-decoration: none; text-align: center; padding: .5rem;
            transition: transform .15s ease;
        }
        .post:hover { transform: rotate(-2deg) scale(1.02); }
        .post__icone { font-size: clamp(2rem, 6vw, 3.4rem); line-height: 1; }
        .post__legenda { font-family: var(--titulo); font-weight: 700; font-size: clamp(.9rem, 2vw, 1.15rem); }
        @media (max-width: 560px) { .insta__grade { gap: .6rem; } }

        /* ---------- Contato ---------- */
        .contato__grade { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; }
        .contato p.lead { margin: 1rem 0 1.8rem; color: var(--tinta-suave); max-width: 44ch; }
        .dados { display: grid; gap: 1rem; margin: 0; }
        .dados div { border: 3px solid var(--borda); border-radius: 16px; padding: .9rem 1.2rem; background: var(--pessego-claro); }
        .dados dt { font-family: var(--titulo); font-weight: 700; font-size: 1.05rem; }
        .dados dd { margin: 0; color: var(--tinta-suave); }
        .dados dd a { font-weight: 700; color: var(--tinta); text-underline-offset: 3px; }
        @media (max-width: 860px) { .contato__grade { grid-template-columns: 1fr; } }

        /* ---------- Rodapé ---------- */
        .rodape { background: #d9480f; color: #ffffff; padding: 2rem 0; font-size: .95rem; }
        .rodape__interno { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1rem; }
        .rodape a { text-decoration: underline; text-underline-offset: 4px; }
    </style>
</head>
<body>

    <header class="topo">
        <div class="container topo__interno">
            <a class="marca" href="#inicio" aria-label="{{ $escola['nome'] }} – início">
                @if ($temLogo)
                    <img class="marca__logo" src="{{ asset('images/logo-sol.png') }}" alt="" width="44" height="36">
                @else
                    <span class="marca__sol" aria-hidden="true"></span>
                @endif
                {{ $escola['nome'] }}
            </a>
            <nav class="menu" aria-label="Principal">
                <a href="#sobre">Sobre</a>
                <a href="#fotos">Fotos</a>
                <a href="#ensino">Ensino</a>
                <a href="#instagram">Novidades</a>
                <a class="botao botao--principal" href="#contato">Matrícula</a>
            </nav>
        </div>
    </header>

    <main>
        {{-- INÍCIO --}}
        <section class="inicio" id="inicio">
            <div class="container inicio__grade">
                <div>
                    <h1>
                        <span class="pequeno">Bem-vindo ao</span>
                        <span>Colégio</span>
                        <span>Apollinho</span>
                    </h1>
                    <p class="lead">
                        Um lugar para aprender com alegria, fazer amigos e crescer com a família por perto.
                    </p>
                    <ul class="chips">
                        <li>{{ $escola['niveis'] }}</li>
                        <li>{{ $escola['horario'] }}</li>
                    </ul>
                    <div class="inicio__acoes">
                        <a class="botao botao--principal" href="{{ $urlWhatsapp }}" target="_blank" rel="noopener">Falar no WhatsApp</a>
                        <a class="botao botao--contorno" href="{{ $urlInstagram }}" target="_blank" rel="noopener">Ver o Instagram</a>
                    </div>
                </div>

                @if ($temLogo)
                    <img class="sol-logo" src="{{ asset('images/logo-sol.png') }}" alt="Logo do {{ $escola['nome'] }}: um sol sorridente" width="492" height="406">
                @else
                <div class="sol-ilustracao" aria-hidden="true">
                    <svg class="sol-ilustracao__raios" viewBox="0 0 200 200">
                        @for ($i = 0; $i < 12; $i++)
                            <rect x="95" y="4" width="10" height="30" rx="5" fill="{{ $i % 2 ? '#f97218' : '#fbbb25' }}" stroke="#ff8a2a" stroke-width="3"
                                  transform="rotate({{ $i * 30 }} 100 100)"/>
                        @endfor
                    </svg>
                    <div class="sol-ilustracao__miolo">
                        <svg class="rosto" viewBox="0 0 100 70">
                            <circle cx="30" cy="22" r="6" fill="#e8590c"/>
                            <circle cx="70" cy="22" r="6" fill="#e8590c"/>
                            <path d="M22 42 Q50 72 78 42" fill="none" stroke="#e8590c" stroke-width="6" stroke-linecap="round"/>
                            <circle cx="16" cy="40" r="7" fill="#f8a15a" opacity=".8"/>
                            <circle cx="84" cy="40" r="7" fill="#f8a15a" opacity=".8"/>
                        </svg>
                    </div>
                </div>
                @endif
            </div>
        </section>

        <svg class="onda" viewBox="0 0 1440 90" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 50 C180 100 360 0 600 40 S1000 100 1200 40 S1380 10 1440 40 V90 H0 Z" fill="#ffd9b8"/>
        </svg>

        {{-- SOBRE --}}
        <section class="sobre" id="sobre">
            <div class="container sobre__grade">
                <div>
                    <h2>Uma escola feita para crescer junto</h2>
                    <p>
                        {{-- ✏️ Substitua pelo texto oficial da escola (história, proposta pedagógica, valores). --}}
                        No {{ $escola['nome'] }}, cada criança é conhecida pelo nome. Nosso trabalho é
                        cuidar da aprendizagem e do bem-estar, em parceria com as famílias.
                    </p>
                </div>
                <ul class="lista">
                    @foreach ($diferenciais as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- GALERIA / CARROSSEL --}}
        <section class="galeria" id="fotos">
            <div class="container">
                <div class="galeria__cabeca">
                    <h2>Conheça nossos espaços</h2>
                    <p>Salas, cantinhos e momentos do dia a dia na escola.</p>
                </div>

                <div class="carrossel" role="region" aria-roledescription="carrossel" aria-label="Fotos da escola">
                    <button type="button" class="carrossel__botao carrossel__botao--ant" aria-label="Foto anterior">&#8249;</button>
                    <div class="carrossel__pista" tabindex="0">
                        @foreach ($fotos as $i => $foto)
                            <figure class="carrossel__slide" aria-label="Foto {{ $i + 1 }} de {{ count($fotos) }}">
                                @if (file_exists(public_path('images/carrossel/' . $foto['arquivo'])))
                                    <img src="{{ asset('images/carrossel/' . $foto['arquivo']) }}" alt="{{ $foto['alt'] }}"
                                         width="1448" height="1086" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                                @else
                                    <div class="carrossel__vazio">
                                        <span>Foto {{ $i + 1 }}</span>
                                        <small>Salve em public/images/carrossel/{{ $foto['arquivo'] }}<br>1448 × 1086 px (4:3)</small>
                                    </div>
                                @endif
                            </figure>
                        @endforeach
                    </div>
                    <button type="button" class="carrossel__botao carrossel__botao--prox" aria-label="Próxima foto">&#8250;</button>
                    <div class="carrossel__pontos"></div>
                </div>
            </div>
        </section>

        {{-- ENSINO --}}
        <section id="ensino">
            <div class="container">
                <div class="etapas__cabeca">
                    <h2>Do Berçário ao G5</h2>
                    <p>Cada fase tem um ritmo próprio, em turno integral. Veja onde seu filho se encaixa.</p>
                </div>
                <div class="etapas__grade">
                    @foreach ($etapas as $etapa)
                        <article class="etapa cor-{{ $etapa['cor'] }}">
                            <small>{{ $etapa['idade'] }}</small>
                            <h3>{{ $etapa['titulo'] }}</h3>
                            <p>{{ $etapa['texto'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- INSTAGRAM --}}
        <section class="insta" id="instagram">
            <div class="container">
                <div class="insta__cabeca">
                    <div>
                        <h2>Acompanhe no Instagram</h2>
                        <p>Fotos, eventos e avisos em &#64;{{ $escola['instagram'] }}.</p>
                    </div>
                    <a class="botao botao--principal" href="{{ $urlInstagram }}" target="_blank" rel="noopener">Seguir a escola</a>
                </div>

                {{-- Tiles ilustrativos. Para exibir as fotos reais, veja a observação na resposta. --}}
                <div class="insta__grade">
                    @foreach ($posts as $post)
                        <a class="post cor-{{ $post['cor'] }}" href="{{ $urlInstagram }}" target="_blank" rel="noopener">
                            <span class="post__icone" aria-hidden="true">{{ $post['icone'] }}</span>
                            <span class="post__legenda">{{ $post['legenda'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CONTATO --}}
        <section id="contato">
            <div class="container contato__grade">
                <div>
                    <h2>Venha conhecer a escola</h2>
                    <p class="lead">Chame no WhatsApp para tirar dúvidas, saber valores e agendar uma visita. Atendemos do Berçário ao G5, em turno integral.</p>
                    <a class="botao botao--principal" href="{{ $urlWhatsapp }}" target="_blank" rel="noopener">Pedir informações</a>
                </div>
                <dl class="dados">
                    <div><dt>Ensino</dt><dd>{{ $escola['niveis'] }} · {{ $escola['horario'] }}</dd></div>
                    <div><dt>WhatsApp</dt><dd><a href="{{ $urlWhatsapp }}" target="_blank" rel="noopener">{{ $escola['telefone'] }}</a></dd></div>
                    <div><dt>Instagram</dt><dd><a href="{{ $urlInstagram }}" target="_blank" rel="noopener">&#64;{{ $escola['instagram'] }}</a></dd></div>
                    @if (!empty($escola['endereco']))
                        <div><dt>Endereço</dt><dd>{{ $escola['endereco'] }}</dd></div>
                    @endif
                    @if (!empty($escola['email']))
                        <div><dt>E-mail</dt><dd>{{ $escola['email'] }}</dd></div>
                    @endif
                </dl>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <div class="container rodape__interno">
            <span>© {{ date('Y') }} {{ $escola['nome'] }} · {{ $escola['niveis'] }} · {{ $escola['horario'] }}</span>
            <span><a href="{{ $urlWhatsapp }}" target="_blank" rel="noopener">{{ $escola['telefone'] }}</a> · <a href="{{ $urlInstagram }}" target="_blank" rel="noopener">&#64;{{ $escola['instagram'] }}</a></span>
        </div>
    </footer>


    <script>
        (function () {
            var raiz = document.querySelector('.carrossel');
            if (!raiz) return;
            var pista = raiz.querySelector('.carrossel__pista');
            var slides = pista.children;
            var pontos = raiz.querySelector('.carrossel__pontos');
            var atual = 0;
            var reduz = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            for (var i = 0; i < slides.length; i++) {
                var b = document.createElement('button');
                b.type = 'button';
                b.className = 'carrossel__ponto';
                b.setAttribute('aria-label', 'Ir para a foto ' + (i + 1));
                b.dataset.i = i;
                pontos.appendChild(b);
            }

            function ir(n) {
                atual = (n + slides.length) % slides.length;
                pista.scrollTo({ left: atual * pista.clientWidth, behavior: reduz ? 'auto' : 'smooth' });
            }
            function marcar() {
                atual = Math.round(pista.scrollLeft / pista.clientWidth);
                Array.prototype.forEach.call(pontos.children, function (p, i) {
                    if (i === atual) p.setAttribute('aria-current', 'true'); else p.removeAttribute('aria-current');
                });
            }

            raiz.querySelector('.carrossel__botao--ant').addEventListener('click', function () { ir(atual - 1); });
            raiz.querySelector('.carrossel__botao--prox').addEventListener('click', function () { ir(atual + 1); });
            pontos.addEventListener('click', function (e) { if (e.target.dataset.i) ir(+e.target.dataset.i); });
            pista.addEventListener('scroll', function () { window.requestAnimationFrame(marcar); });
            pista.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowLeft') { e.preventDefault(); ir(atual - 1); }
                if (e.key === 'ArrowRight') { e.preventDefault(); ir(atual + 1); }
            });
            window.addEventListener('resize', function () { pista.scrollTo({ left: atual * pista.clientWidth }); });
            marcar();

            // Troca automática a cada 5 s; pausa ao passar o mouse/focar e não roda com "reduzir movimento".
            if (!reduz && slides.length > 1) {
                var timer = setInterval(function () { ir(atual + 1); }, 5000);
                ['mouseenter', 'focusin', 'touchstart'].forEach(function (ev) {
                    raiz.addEventListener(ev, function () { clearInterval(timer); }, { passive: true });
                });
            }
        })();
    </script>

</body>
</html>