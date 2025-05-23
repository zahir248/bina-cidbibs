<footer class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="mb-4">MySite</h5>
                <p>Providing innovative solutions to help businesses grow and succeed in the digital age.</p>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                <h5 class="mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50">Home</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50">Features</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50">About</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                <h5 class="mb-4">Services</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50">Web Design</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50">Development</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50">Marketing</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50">Consulting</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5 class="mb-4">Newsletter</h5>
                <p>Subscribe to our newsletter for the latest updates and offers.</p>
                <form class="d-flex" action="#" method="POST">
                    @csrf
                    <input type="email" class="form-control me-2" placeholder="Your Email" name="email" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; {{ date('Y') }} MySite. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white-50 me-3">Privacy Policy</a>
                <a href="#" class="text-white-50">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>