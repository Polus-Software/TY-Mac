@extends('Layouts.myCourses')
@section('content')
<section>
        <div class="container">
            <div class="row border-bottom mt-3 pb-3">
               <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                <h3>Current Live Classes</h3>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6 col-6 d-flex justify-content-end">
                <ul class="nav nav-tabs border-0">
                    <li class="active"><a data-toggle="tab" href="#" class="btn btn-outline-dark active">Live</a></li>
                    <li><a data-toggle="tab" href="#menu1" class="btn btn-outline-dark ">Upcoming</a></li>
                   
                  </ul>
                    <!-- <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn btn-outline-dark active toggle-btn">Live</button>
                        <button type="button" class="btn btn-outline-dark toggle-btn">Upcoming</button>
                    </div> -->
               </div>
            </div>
        </div>
    </section>



<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                               <div class="col-lg-4 col-12">
                                  <div class="card-1" style="width: 395px;">
                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                    <!-- <i class="far fa-play-circle"></i> -->
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive</h5>
                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                            <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12 item-2"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                    <div class="col-lg-6 col-12 item-3"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p>
                                                   </div>
                                                </div>
                                           </li>
                                            
                                            </ul>
                                    </div>
                                    <div class="card-footer text-center border-0">
                                        <a href="" class="card-link btn">Join now</a>
                                        </div>
                                    </div>
                                    
                              </div>

                                <div class="col-lg-4">
                                   <div class="card-1" style="width: 395px;">
                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                    <!-- <i class="far fa-play-circle"></i> -->
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive</h5>
                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                            <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row">
                                                
                                                <div class="col-lg-6 col-12 item-2"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                <div class="col-lg-6 col-12 item-3"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p>
                                                    </div>
                                            </div></li>
                                            
                                            </ul>
                                    </div>
                                    <div class="card-footer text-center border-0">
                                        <a href="" class="card-link btn">Join now</a>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-4">
                                   <div class="card-1" style="width: 395px;">
                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                    <!-- <i class="far fa-play-circle"></i> -->
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive</h5>
                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                            <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row">
                                                
                                                <div class="col-lg-6 col-12 item-2"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                <div class="col-lg-6 col-12 item-3"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p>
                                                    </div>
                                            </div></li>
                                            
                                            </ul>
                                    </div>
                                    <div class="card-footer text-center border-0">
                                        <a href="" class="card-link btn">Join now</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                        <div class="row">
                              <div class="col-lg-4">
                                <div class="card-1" style="width: 395px;">
                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                    <!-- <i class="far fa-play-circle"></i> -->
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive</h5>
                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                            <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row">
                                                
                                                <div class="col-lg-6 col-12 item-2"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                <div class="col-lg-6 col-12 item-3"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p>
                                                    </div>
                                            </div></li>
                                            
                                            </ul>
                                    </div>
                                    <div class="card-footer text-center border-0">
                                        <a href="" class="card-link btn">Join now</a>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-4">
                                   <div class="card-1" style="width: 395px;">
                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                    <!-- <i class="far fa-play-circle"></i> -->
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive</h5>
                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                            <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row">
                                                
                                                <div class="col-lg-6 col-12 item-2"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                <div class="col-lg-6 col-12 item-3"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p>
                                                    </div>
                                            </div></li>
                                            
                                            </ul>
                                    </div>
                                    <div class="card-footer text-center border-0">
                                        <a href="" class="card-link btn">Join now</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                <div class="card-1" style="width: 395px;">
                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                    <!-- <i class="far fa-play-circle"></i> -->
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Fundamentals of Google Docs & Google Drive</h5>
                                        <p class="card-text text-sm-start">By learning both of these apps, you will gain valuable productivity skills &
                                            become more efficient at creating documents, spreadsheets, and presentations.</p>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12 item-2"><p><i class="far fa-user pe-1"></i>instructor</p></div>
                                                        <div class="col-lg-6 col-12 item-3"><p class="text-end"><i class="far fa-user pe-1"></i> beginner</p></div>
                                                    </div>
                                                </li>
                                            </ul>
                                    </div>
                                    <div class="card-footer text-center border-0">
                                        <a href="" class="card-link btn">Join now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon btn-dark" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon btn-dark" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>  
            </div>
                 
        </div>
    </div>
</section>



<section class="mt-5">
    <div class="container">
        <div class="row border-bottom pb-3">
            <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-start">
                <h3>My Courses</h3>
              </div>
              <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-end">
               <select name="" id="" class="rounded pe-4" >
                 <option value="most-popular">Course in progress</option>
                 <option value="">Most Popular</option>
                 <option value="">Most Popular</option>
                 <option value="">Most Popular</option>
               </select>
              </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card-2 mb-3 mt-4">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <img src="courselist/Illustration/Mask Group 2.jpg" class="img-fluid coursepicture col-md-12 col-sm-12 col-12 h-100" alt="coursepicture">
                        </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                <div class="card-body">
                                    <h5 class="card-title pb-3">
                                        Fundamentals of Google Docs & Google Drive
                                    </h5>
                                    <p class="card-text">By learning both of these apps, 
                                        you will gain valuable productivity skills & become more efficient at creating documents, spreadsheets, 
                                        and presentations.</p>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                            <div class="progress rounded-pill">
                                                <div class="progress-bar rounded-pill text-end pe-2" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                              </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><i class="fas fa-tag fa-flip-horizontal ps-1"></i>
                                                   catogory
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><i class="far fa-user pe-1"></i>
                                                   instructor
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                <p class="para-2"><i class="far fa-user pe-1"></i>        
                                                    beginner
                                                </p>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <p class="duration"><i class="far fa-clock pe-1"></i>
                                                Next cohort:  <small> 11/19/2021 - 9 AM IST - 10 AM IST</small>
                                              </p>
                                            </div>
                                       
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-2 mb-3 mt-4">
                            <div class="row g-0">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <img src="courselist/Illustration/Mask Group 2.jpg" class="img-fluid coursepicture col-md-12 col-sm-12 col-12 h-100" alt="coursepicture">
                                </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                        <div class="card-body">
                                            <h5 class="card-title pb-3">
                                                Fundamentals of Google Docs & Google Drive
                                            </h5>
                                            <p class="card-text">By learning both of these apps, 
                                                you will gain valuable productivity skills & become more efficient at creating documents, spreadsheets, 
                                                and presentations.</p>
                                            <div class="row">
                                                <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                                    <div class="progress rounded-pill">
                                                        <div class="progress-bar rounded-pill text-end pe-2" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                      </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                                        <p class="para-1"><i class="fas fa-tag fa-flip-horizontal ps-1"></i>
                                                           catogory
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                                        <p class="para-1"><i class="far fa-user pe-1"></i>
                                                           instructor
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                        <p class="para-2"><i class="far fa-user pe-1"></i>        
                                                            beginner
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                        <p class="duration"><i class="far fa-clock pe-1"></i>
                                                        Next cohort:  <small> 11/19/2021 - 9 AM IST - 10 AM IST</small>
                                                      </p>
                                                    </div>
                                               
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-2 mb-3 mt-4">
                                    <div class="row g-0">
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                            <img src="courselist/Illustration/Mask Group 2.jpg" class="img-fluid coursepicture col-md-12 col-sm-12 col-12 h-100" alt="coursepicture">
                                        </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                                <div class="card-body">
                                                    <h5 class="card-title pb-3">
                                                        Fundamentals of Google Docs & Google Drive
                                                    </h5>
                                                    <p class="card-text">By learning both of these apps, 
                                                        you will gain valuable productivity skills & become more efficient at creating documents, spreadsheets, 
                                                        and presentations.</p>
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                                            <div class="progress rounded-pill">
                                                                <div class="progress-bar rounded-pill text-end pe-2" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                              </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                                                <p class="para-1"><i class="fas fa-tag fa-flip-horizontal ps-1"></i>
                                                                   catogory
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                                                <p class="para-1"><i class="far fa-user pe-1"></i>
                                                                   instructor
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                                <p class="para-2"><i class="far fa-user pe-1"></i>        
                                                                    beginner
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <p class="duration"><i class="far fa-clock pe-1"></i>
                                                                Next cohort:  <small> 11/19/2021 - 9 AM IST - 10 AM IST</small>
                                                              </p>
                                                            </div>
                                                       
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
   

</section>

@endsection('content')