<script>
// Auto-hide navbar on scroll
let lastScrollTop = 0;
const navbar = document.getElementById('mainNavbar');
let scrollTimeout;

window.addEventListener('scroll', function() {
    clearTimeout(scrollTimeout);
    
    scrollTimeout = setTimeout(function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
            if (scrollTop > lastScrollTop) {
                navbar.classList.add('navbar-hidden');
            } else {
                navbar.classList.remove('navbar-hidden');
            }
        } else {
            navbar.classList.remove('navbar-hidden');
        }
        
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }, 10);
});

// Handle mobile viewport height issues
function setMobileVH() {
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}

setMobileVH();
window.addEventListener('resize', setMobileVH);
window.addEventListener('orientationchange', function() {
    setTimeout(setMobileVH, 100);
});
</script> 