<?php
use Eren\Lms\Models\RatingModal;

?>
@extends(config('setting.guest_blade'))
@section('page-css')
    <style>
        @media all and (min-width: 576px) {
            .fix-height {
                height: 26rem !important;
            }
        }

        .fix-height {
            height: 24rem !important;
        }
    </style>
@endsection
@section('content')

    <div class="container-fluid my-5" style="min-height: 100vh !important">
        <h1 class="text-center"> My Learning </h1>

        @if (isset($courses) && $courses->count())
            <div class="row mt-2 row-cols-md-5">
                @foreach ($courses as $course)
                    @php $ci = $course->course_image; @endphp
                    <div class="col-12 col-md mt-2">
                        @if ($course->slug)
                            <div class="card fix-height" style="width: 18rem;" data-aos="zoom-out-up"
                                data-aos-anchor-placement="bottom-bottom">
                                <a href="{{ route('user-course', ['slug' => $course->slug]) }}">
                                    @if ($ci)
                                        <img class="card-img-top img-fluid"
                                            src="{{ config('setting.s3Url') . $ci->image_path }}"
                                            alt="{{ $ci->image_name }}">
                                    @endif
                                </a>
                                @php
                                    $rating_avg = (int) RatingModal::where('course_id', $course->id)->avg('rating');
                                    $rated_by_students = (int) RatingModal::where('course_id', $course->id)->count(
                                        'rating',
                                    );
                                @endphp
                                {{-- <div class="card-body">
                            <h5 class="card-title font-bold text-capitalize"> {{ $course->course_title ?? ''}} </h5>
                            <p class="card-text text-capitalize mt-1"> By <span class="font-bold"> {{ $course->user->name ?? '' }} </span> </p>
                            <p class="card-text text-capitalize mt-1"> Category {{ $course->categories_selection ?? '' }} </p>                            
                            <p class="card-text text-capitalize mt-1"> @if ($course->price->is_free)  {{ __('lms::free') }} @else ${{ $course->price->pricing ?? '' }} @endif </p>                    
                        </div> --}}
                                <div class="card-body" style="height: 150px">
                                    <h5 class="card-title font-bold text-capitalize"
                                        style="font-size: 1.1rem;font-weight:bold">
                                        {{ reduceCharIfAv($course->course_title ?? '', 40) }} </h5>
                                    <p class="card-text text-capitalize mb-0 mt-1"><span class="">
                                            {{ reduceWithStripping($course->user->name, 20) ?? '' }} </span>
                                    </p>
                                    <p
                                        class="mb-0 mt-1 @if ($course->categories_selection == 'it') {{ 'text-uppercase' }} @else {{ 'text-capitalize' }} @endif">
                                        {{ reduceWithStripping($course->categories_selection, 20) ?? '' }} </p>
                                    @if ($rating_avg)
                                        <div class="d-flex align-items-center">
                                            <section id="rating" class="d-flex align-items-center"
                                                style="cursor: pointer">
                                                {{ $rating_avg }}

                                                <span
                                                    class="fa fa-star  @if ($rating_avg >= 1) {{ 'text-warning' }} @endif"
                                                    no="1"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 2) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="2"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 3) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="3"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 4) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="4"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 5) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="5"></span>
                                                <span class="ml-1">( {{ $rated_by_students }} )</span>
                                            </section>
                                        </div>
                                    @endif
                                    <p class="card-text text-capitalize  mb-0  mt-1 d-flex font-bold">
                                        @if ($course->price->is_free)
                                            {{ __('lms::free') }}
                                        @else
                                            <span style="font-weight:bold"> ${{ $course->price->pricing ?? '' }} </span>
                                            @php $total_p = ((int)$course->price->pricing)+20 @endphp
                                            <del class="ml-2"> ${{ $total_p }} </del>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        @else
            <div class="jumbotron bg-white text-dark text-center">
                <h2> No {{ __('lms::coupon.Enrollment') }} Found</h2>
                <div> you are not enrolled in any course. please enroll in any course and then come back to here</div>
            </div>
        @endif
    </div>

@endsection
