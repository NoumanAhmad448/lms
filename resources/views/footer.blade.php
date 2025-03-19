<div class="container-fluid">
    <footer class="footer-bg mt-auto">
        <div class="container-fluid">
            <div class="row pt-2 pt-md-5">
                <div class="col-md-3 mt-3 mt-md-0">
                    <h3 class="mb-3"> About US </h3>
                    <div class="text-justify">
                        lms is a LMS platform that connect Teachers with Students globally. Teachers create high quality
                        course
                        and present them in super easy way
                    </div>

                </div>

                <div class="col-md-3 mt-3 mt-md-0">
                    <h3 class="mb-3"> Links </h3>
                    <ul class="list-unstyled">
                        <li class="mt-2"><a class="text-white" href="{{ route('login') }}"> Login </a></li>
                        <li class="mt-2"><a class="text-white" href="{{ route('register') }}"> Register </a></li>
                        <li class="mt-2"><a class="text-white" href="{{ url('forgot-password') }}"> Forget Password
                            </a></li>
                        <li class="mt-2"><a class="text-white" href="{{ route('index') }}"> Home </a></li>
                    </ul>

                </div>

                <div class="col-md-3 mt-3 mt-md-0">
                    <ul class="list-unstyled">
                        <li class="mt-2"><a class="text-white" href="https://lms.com/page/about-us"> About Us </a>
                        </li>
                        <li class="mt-2"><a class="text-white" href="https://lms.com/page/privacy-policy"> Privacy
                                Policy </a>
                        </li>
                        <li class="mt-2"><a class="text-white" href="https://lms.com/page/terms-and-conditions"> Terms
                                &
                                Conditions
                            </a></li>
                    </ul>
                </div>

                <div class="col-md-3 mt-3 mt-md-0">
                    <h3 class="mb-3">Our Office </h3>
                    <div>
                    </div>

                    <h3 class="my-3">Follow Us</h3>
                    <div class="d-inline text-white">
                        <a class="text-white mr-2" href="https://www.facebook.com/lms-113826713695283">
                            <i class="fa fa-facebook-official" aria-hidden="true"></i>
                        </a>

                        <a class="text-white mr-2" href="https://www.instagram.com/lms/">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a class="text-white mr-2" href="https://www.youtube.com/channel/UCa-M0ECvodmuNP8wlzm_YIQ">
                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                        </a>
                        <a class="text-white mr-2" href="https://wa.me/923349376619"> <i class="fa fa-whatsapp"
                                aria-hidden="true"></i>
                        </a>
                        <a class="text-white mr-2" href="https://www.linkedin.com/company/lms"> <i
                                class="fa fa-linkedin" aria-hidden="true"></i>
                        </a>
                        <a class="text-white" href="https://twitter.com/lms1"> <i class="fa fa-twitter"
                                aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

            </div>
            <div class="row mt-3 pb-3">
                <div class="col">
                    <p class="text-center">&copy; Copyright {{ date('Y') }}- lms. All Rights Are Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
<script src="{{ asset('vendor/lms/js/main.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

<!--load whatsapp-->
<a href="https://wa.me/923349376619" class="whatsapp mr-3 mb-4" style="position: fixed; left: 5;bottom:0"> <img
        src="https://img.icons8.com/color/48/000000/whatsapp--v4.png" style="width: 4.5rem" alt="whatsapp" /> </a>
<!--messenger-->

<script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0&appId=444177396566651&autoLogAppEvents=1"
    nonce="XPw3MZUm"></script>
<!-- Load Facebook SDK for JavaScript -->
<!-- Your Chat Plugin code -->
<div class="fb-customerchat" style="bottom: 10px" attribution=setup_tool page_id="113826713695283"
    greeting_dialog_display="hide">
</div>

@yield('script')
