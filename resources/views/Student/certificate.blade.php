
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet"> -->
    
    @foreach($courseDetails as $courseDetail)
    <title> {{$courseDetail['course_title']}} Certificate</title>
    @endforeach
    <style>


.card-title{
    padding-bottom:35px;
    text-align: center;
    font-family: 'Roboto', sans-serif;
    font-weight: 900;
    margin-top:55px;
    
}

.card-title-1{
    color:#F5BC29;
    text-align: center;
    padding-bottom: 40px;
    padding-top:20px;
    font-family: 'Roboto', sans-serif;
    font-weight: 900;
    font-size:28px;
   
}
.card-text-1{
    text-align: center;
    font-family: 'Roboto', sans-serif;
    font-weight: 400; 
    color: #6E7687;
}
.card-text-2{
    text-align: center;
    font-family: 'Roboto', sans-serif;
    font-weight: 900; 
    border-bottom:1px solid #F5BC29;
    padding-bottom:30px;
    font-size:28px;
}
.signature-img{
    display: block;
    margin: 0 auto;
    /* border-bottom:1px solid #F5BC29; */
    
}
.signature{
    border-bottom:1px solid #F5BC29;
    padding-bottom:30px;
}

    </style>
</head>
<body>
    
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12 d-flex justify-content-center">
            <div class="card text-center" style="margin: auto; width: 100%; border: 1px solid grey; margin-bottom:30px;">
                <div class="card-body">
                    @foreach($courseDetails as $courseDetail)
                    <small style="position: absolute; left: 0px; top:20px; left:15px;">ThinkLit</small>
                    <small style="position: absolute; right: 35px; top:20px;">DATE OF ISSUE :</small>
                    <small style="position: absolute; right: 45px; top:40px;">{{$courseDetail['course_completion']}}</small>
                    <!-- <h1 class="card-title">ThinkLit</h1> -->
                    <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('/storage/icons/ty_mac__transparent__1000.png')))}}" alt="" class="img-fluid" style="width:180px; height:180px; display: block;
    margin: 0 auto;">
                    <div style="background:#FFF9E8; padding-bottom:5px; margin-bottom:20px; margin-left:20px; margin-right:20px;">
                    <h3 class="card-title-1">Certificate of Completion</h3>
                    <p class="card-text-2">{{$courseDetail['student_firstname']}} {{$courseDetail['student_lastname']}}</p>
                  <div class="row">
                    <div class="col-lg-12">
                        <p class="card-text-1">Has successfully completed the {{$courseDetail['course_title']}} <br>
                            online cohort on {{$courseDetail['course_completion']}}</p>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-12">
                        <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('/storage/signatures/'.$courseDetail['instructor_signature'])))}}" alt="" class="signature-img signature">
                    </div>
                      <div class="col-lg-12">
                        <p class="card-text-1">{{$courseDetail['instructor_firstname']}} {{$courseDetail['instructor_lastname']}}, Instructor</p>
                        <p class="card-text-1" style="margin-bottom:10px;">&<br> Team ThinkLit</p>
                      </div>
                  </div>
                  </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>