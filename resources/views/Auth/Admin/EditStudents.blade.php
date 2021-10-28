

@extends('Layouts.Profile')

@section('content')
<div class="container">
       
     
               <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9">
                   <div class="content-page">
                   <form class="form"  id="editUserForm" method="POST" action="">
                           @csrf
                           @method('PUT')
                            <div class="row">
                             <div class="form-group col-md-6 col-sm-6 col-xs-2">
                               <label for="fname" class="firstname-label">First Name</label>
                               <input type="text" class="form-control" name="firstname" id="firstname" >
                               <small>Error message</small>
                                   
                            
                             </div>
                             <div class="form-group col-md-6 col-sm-6 col-xs-2">
                               <label for="lname" class="lastname-label">Last Name</label>
                               <input type="text" class="form-control" name="lastname" id="lastname">
                               <small>Error message</small>
                            
                             </div>
                           </div>
                           <div class="row">
                             <div class="form-group col-md-12 col-sm-12 col-xs-2">
                               <label for="email" class="email-label">Email</label>
                               <input type="email" class="form-control"  name="email" id="email">
                               <small>Error message</small>

                               
                             </div>
                           </div>
                           <div class="row">
                               <div class="form-group buttons d-flex justify-content-end">
                                  
                                   
                                   <button type="submit" class="btn update-btn">Update</button>
                               </div>
                           </div>
                         </form>    
                        
                       </div>
                      
                         
                   </div>
               </div>
           </div>

       </div>
</div>
<script src="{{ asset('assets/editUser.js') }}"></script>


@endsection('content')