document.addEventListener('DOMContentLoaded', function() {
    var aboutSection = document.getElementById('about');
    function checkScroll() {
        var rect = aboutSection.getBoundingClientRect();
        var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
        // Check if the top of the section is within the viewport
        if (rect.top <= viewHeight * 0.75 && !aboutSection.classList.contains('show')) {
            aboutSection.classList.add('animate__animated', 'animate__fadeInUp'); // Use Animate.css classes
            aboutSection.classList.add('show');
            // Remove the scroll listener after animation applied
            window.removeEventListener('scroll', checkScroll);
        }
    }
    window.addEventListener('scroll', checkScroll);
    checkScroll(); // Check on page load
});
