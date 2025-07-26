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
