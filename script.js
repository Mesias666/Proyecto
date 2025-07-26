$(document).ready(function () {
  // Detecta scroll
  $(window).on('scroll', function () {
    let scrollPos = $(document).scrollTop();

    $('.nav-link').each(function () {
      let sectionId = $(this).attr('href');
      let section = $(sectionId);

      if (section.length) {
        let offsetTop = section.offset().top - 100; // Ajusta si navbar es fijo
        let offsetBottom = offsetTop + section.outerHeight();

        if (scrollPos >= offsetTop && scrollPos < offsetBottom) {
          $('.nav-link').removeClass('active');
          $(this).addClass('active');
        }
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const canciones = [
    'audio/p1_Spirit_In_The_Sky.mp3',
    'audio/p2_Hooked_on_a_Feeling.mp3',
    'audio/p3_I_want_you_back.mp3'
  ];

  let indiceActual = 0;
  let reproductor = new Audio(canciones[indiceActual]);

  document.getElementById('btnPlay').addEventListener('click', () => {
    reproductor.play();
  });

  document.getElementById('btnPause').addEventListener('click', () => {
    reproductor.pause();
  });

  document.getElementById('btnNext').addEventListener('click', () => {
    reproductor.pause();
    indiceActual = (indiceActual + 1) % canciones.length;
    reproductor = new Audio(canciones[indiceActual]);
    reproductor.play();
  });

  document.getElementById('btnStop').addEventListener('click', () => {
    reproductor.pause();
    reproductor.currentTime = 0;
  });

  document.getElementById('volumen').addEventListener('input', (e) => {
    reproductor.volume = e.target.value;
  });
});

