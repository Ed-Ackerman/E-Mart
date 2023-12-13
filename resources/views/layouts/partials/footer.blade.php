<footer class="footer">
    <div class="footer-info">
        <div class="footer-contact">
            <div class="footer-header">{{__('Contact_Us')}}</div>
            <hr>
            <div class="footer-text">
                {{__('  Spend Less For More.')}} <br>
                {{__('Your information is safe with Us.')}} <br>
                {{__('Finest Quality Online Shopping Store in Uganda. ')}} 
            </div>
            <div class="contact-info">
                <a href=""><i class="fa fa-map-marker"></i>{{__('Kampala Uganda')}}</a>
                <a href=""><i class="fa fa-envelope"></i>{{__('info@emart.com')}}</a>
                <a href=""><i class="fa fa-phone"></i>{{__('200-800-3664')}}</a>
                <a href=""><i class="fa fa-mobile"></i>{{__('+256-788276076')}}</a>
                <a href=""><i class="fa fa-clock"></i>{{__('24/7-365 Days')}}</a>
            </div>
        </div>
        <div class="footer-help">
            <div class="footer-header">{{__('Need Help')}}</div>
            <hr>
            <div class="footer-text">
              {{__('Explore our online store for exclusive deals and discounts.')}} <br>
              {{__('Rest assured, your personal information is secure with us.')}} <br>
            </div>
            <div class="contact-info">
              <a href="{{route('client.help')}}"><i class="fas fa-question-circle"></i>{{__('Help Center')}}</a>
              <a href="{{route('client.help')}}"><i class="fas fa-info-circle"></i>{{__('Faqs')}}</a>
              <a href="{{route('client.help')}}"><i class="fas fa-envelope"></i>{{__('Contact Us')}}</a>
              <a href="{{route('client.returns')}}"><i class="fas fa-retweet"></i>{{__('Returns & Refunds')}}</a>
            </div>
        </div>
          
        <div class="footer-app">
            <div class="footer-header">{{__('Get Connected On Mobile')}}</div>
            <hr>
            <div class="footer-logo"  style="background-image: url('{{ asset('admin/imgs/e-mart-2.png') }}')"></div>
            <div class="contact-info">
                <a href="" class="footer-img" style="background-image: url('{{ asset('client/imgs/apple.png')}}')"></a>
                <a href="" class="footer-img" style="background-image: url('{{ asset('client/imgs/google.png') }}')"></a>
            </div>
            <div class="footer-text">{{__('Follow us on social media')}}</div>
            <hr>
            <div class="nav-icons">
                <a href="#"><i class="fab fa-instagram" style="color: #e4405f;"></i></a>
                <a href="#"><i class="fab fa-tiktok" style="color: #000;"></i></a>
                <a href="#"><i class="fab fa-twitter" style="color: #1da1f2;"></i></a>
                <a href="#"><i class="fab fa-facebook" style="color: #1877f2;"></i></a>
                <a href="#"><i class="fab fa-whatsapp" style="color: #25d366;"></i></a>
            </div>
        </div>
    </div>
    <hr>
    <div class="footer-copy">
        <a href="https://www.zorithindustries.com/">&copy; {{ date('Y') }} <i> {{__('Zorith Industries.')}}</i> {{__('All rights reserved.')}}' </a>
    </div>
</footer>