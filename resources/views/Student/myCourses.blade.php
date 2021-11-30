@extends('Layouts.myCourses')
@section('content')
    <section>
        <div class="container">
            <div class="row border-bottom mt-3 pb-3">
                <div class="col-lg-6 col-md-6 col-sm-7 col-7">
                    <h3>Current Live Classes</h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-5 col-5 d-flex justify-content-end">
                    <ul class="nav nav-tabs border border-dark">
                        <li class="nav-item active">
                            <button class="nav-link active" id="live-tab" type="button" data-bs-toggle="tab"
                                data-bs-target="#live" role="tab" aria-controls="live" aria-selected="true"
                                data-bs-toggle="tab">Live</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="upcoming-tab" type="button" data-bs-toggle="tab"
                                data-bs-target="#upcoming" role="tab" aria-controls="upcoming" aria-selected="false"
                                data-bs-toggle="tab">Upcoming</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>




<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="tab-content">
                <div id="live" class="tab-pane fade show active" aria-labelledby="live-tab">
                    <div class="col-lg-12">
                        <div id="liveCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                        Google Drive 1</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Join now</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12  mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                        Google Drive 2</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Join now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                        Google Drive 3</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Join now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- first slide ends -->

                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                        Google Drive 4</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Join now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                        Google Drive 5</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Join now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                        Google Drive 6</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Join now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#liveCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#liveCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="upcoming" class="tab-pane fade" aria-labelledby="upcoming-tab">
                    <div class="col-lg-12">
                        <div id="upcomingCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">upcoming 1</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">upcoming 2</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">upcoming 3</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- first slide ends -->

                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">upcoming 4</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">upcoming 5</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                            <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">upcoming 6</h5>
                                                    <p class="card-text text-sm-start">By learning both of these apps,
                                                        you will gain valuable productivity skills &
                                                        become more efficient at creating documents, spreadsheets, and
                                                        presentations.</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-6 col-6">
                                                                    <p class="text-end"><i
                                                                            class="far fa-user pe-1"></i> beginner</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="row bg-light">
                                                        <div class="text-center border-top">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#upcomingCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#upcomingCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- <section class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content">
                        <div id="upcoming" class="tab-pane fade" aria-labelledby="upcoming-tab">
                            <div id="upcomingCarousal" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">

                                            <div class="col-lg-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">upcoming: lorem jvg</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                                           become more efficient at creating documents, spreadsheets, and presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p></div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="text-center border-0">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                    <div class="col-lg-4 col-12 mb-4">
                                        <div class="card-1">
                                                <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive 2</h5>
                                                <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                                    become more efficient at creating documents, spreadsheets, and presentations.</p>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-sm-6 col-6"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                            <div class="col-lg-6 col-sm-6 col-6"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="text-center border-0">
                                                    <a href="" class="card-link btn">Go to details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-12 mb-4">
                                        <div class="card-1">
                                            <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive 3</h5>
                                                <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                                    become more efficient at creating documents, spreadsheets, and presentations.</p>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-sm-6 col-6"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                            <div class="col-lg-6 col-sm-6 col-6"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="text-center border-0">
                                                    <a href="" class="card-link btn">Go to details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                            
                       

                                  

                                    <div class="carousel-item">
                                        <div class="row">
                                            <div class="col-lg-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive 4</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p></div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="text-center border-0">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                                
                                            <div class="col-lg-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive 5</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p></div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="text-center border-0">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="col-lg-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive 6</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                                    <div class="col-lg-6 col-sm-6 col-6"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p></div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row text-center border-0">
                                                            <a href="" class="card-link btn">Go to details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>
                                    </div> 
                                </div> 
                                <button class="carousel-control-prev" type="button" data-bs-target="#upcomingCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#upcomingCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </section> -->


    <section class="mt-5">
        <div class="container">
            <div class="row border-bottom pb-3">
                <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-start">
                    <h3>My Courses</h3>
                </div>
                <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-end">
                    <select name="" id="" class="rounded pe-4">
                        <option value="most-popular">Course in progress</option>
                        <option value="">Most Popular</option>
                        <option value="">Most Popular</option>
                        <option value="">Most Popular</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @foreach ($singleEnrolledCourseData as $singleEnrolledCourse)
                        <div class="card-2 mb-3 mt-4">
                            <div class="row g-0">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <img src="{{ asset('/storage/images/' . $singleEnrolledCourse['course_image']) }}"
                                        class="img-fluid coursepicture col-md-12 col-sm-12 col-12 h-100"
                                        alt="coursepicture">
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="card-body">
                                        <h5 class="card-title pb-3">
                                            {{ $singleEnrolledCourse['course_title'] }}
                                        </h5>
                                        <p class="card-text">
                                        {{ $singleEnrolledCourse['description'] }}
                                        </p>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                                <div class="progress rounded-pill">
                                                    <div class="progress-bar rounded-pill text-end pe-2" role="progressbar"
                                                        style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100">25%</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><i
                                                        class="fas fa-tag fa-flip-horizontal ps-1"></i>
                                                    {{ $singleEnrolledCourse['category_name'] }}
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><i class="far fa-user pe-1"></i>
                                                    {{ $singleEnrolledCourse['instructor_firstname'] }}
                                                    {{ $singleEnrolledCourse['instructor_lastname'] }}
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                <p class="para-2"><i class="far fa-user pe-1"></i>
                                                    {{ $singleEnrolledCourse['course_difficulty'] }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <p class="duration"><i class="far fa-clock pe-1"></i>
                                                    Next cohort: <small> {{ $singleEnrolledCourse['start_date'] }} -
                                                        {{ $singleEnrolledCourse['start_time'] }} -
                                                        {{ $singleEnrolledCourse['end_time'] }}</small>
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



        </div>

    </section>

@endsection('content')
