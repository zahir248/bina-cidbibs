<script>
// Show navbar only at top of page
const navbar = document.getElementById('mainNavbar');

function handleScroll() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop <= 0) {
        navbar.classList.add('navbar-visible');
    } else {
        navbar.classList.remove('navbar-visible');
    }
}

// Initial check
handleScroll();

// Add scroll event listener
window.addEventListener('scroll', handleScroll, { passive: true });

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