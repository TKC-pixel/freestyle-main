document.addEventListener("DOMContentLoaded", function() {
    window.addEventListener("scroll", reveal);

    function reveal() {
        var reveals = document.querySelectorAll('.sect');

        for (var i = 0; i < reveals.length; i++) {
            var height = window.innerHeight;
            var revealTop = reveals[i].getBoundingClientRect().top;
            var revealPoint = 150;

            if (revealTop < height - revealPoint) {
                reveals[i].classList.add('active');
            } else {
                reveals[i].classList.remove('active');
            }
        }
        var reveals = document.querySelectorAll('.sect1');

        for (var i = 0; i < reveals.length; i++) {
            var height = window.innerHeight;
            var revealTop = reveals[i].getBoundingClientRect().top;
            var revealPoint = 150;

            if (revealTop < height - revealPoint) {
                reveals[i].classList.add('active');
            } else {
                reveals[i].classList.remove('active');
            }
        }
        
    }
});
