<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Save Links</title>
    <meta name="description" content="Never Miss Any Link"/> 
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js"></script>
    <script src="https://kit.fontawesome.com/6ba88d1a21.js" crossorigin="anonymous"></script>

    <!--Inter UI font-->
    <link href="https://fonts.googleapis.com/css?family=Sen:400,800&display=swap" rel="stylesheet">
    <link href="https://rsms.me/inter/inter-ui.css" rel="stylesheet">
    
    <!--vendors styles-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS / Color Scheme -->
    <link rel="stylesheet" href="{{asset('assets/css/default.css')}}" id="theme-color">
</head>

<body ng-app="myModule" >
    <div ng-controller="myController" ng-init="checkStorage()">
        <!--navigation-->
        <section class="bg-new">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-sm navbar-light">
                    <form ng-submit="verifyEmail()" ng-show="isEmailShow">
                        <div class=" navbar" id="navbarCollapse">
                            <div class="form-inline">
                                <div class="form-group">
                                    <input type="email" class="form-control alternative" placeholder="Enter Email" ng-model="email">
                                </div>
                            </div>
                            <div class="form-inline ml-3">
                                <div class="form-group">
                                    <button type="submit"  value="SAve" class="btn btn-color">Send me link</button>
                                    <!-- <input class="btn btn-color" value="SAve" style="display:none"/> -->
                                </div>
                            </div>
                            <div class="spinner-border text-primary" ng-if="isLoaderShow"></div>
                            <span><%message%></span>
                        </div>
                    </form>
                </nav>
            </div>
        </section>

        <section class="  pt-md-3 bg-new pb-5" id="home">
            <div class="container text-center">
                <h1 class="display-3 font-weight-bold ">Never Miss Any Link</h1>
                <div class="row">
                    <div class="col-6 centerthing">
                        <div class="form-group has-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control form-control-lg alternative-big " placeholder="Search links" name="search" ng-model="search">
                        </div>
                    </div>
                </div>

                <div class="wrapp mt-3">
                    <div class="row mt-3 float-right">
                        <div class="col-3"  style="position: absolute;right: 200px">
                            <button class="btn btn-outline-dark roundedc" ng-show="!addCat" ng-click="showCat()">Add Column</button>
                            <form  ng-submit="saveCategory()" ng-show="addCat">
                                <div class="card" style="width:70%;float:right;margin-bottom:30px">
                                    <input type="text" ng-model="catName" class="form-control" style="display:inline-block" placeholder="Enter Category Name"/>
                                    <input type="submit" style="display:none" value="Save" class="btn btn-success" style="display:inline-block"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-6 back" style="width: 100%; flex-wrap: nowrap;margin: 0;">
                        
                        <div class="col-sm-4 box children" style="width:34rem" ng-repeat="category in categories">
                            <!-- Category Name -->
                            <h3 ng-if="category.id != isEditCat.id"><%category.name%></h3>
                            <form ng-if="category.id == isEditCat.id" ng-submit="saveCatChanges()">
                                <input type="text" ng-model="isEditCat.name"/>
                                <input type="submit" value="Save Changes" style="display:none">
                            </form>
                            <a href="" ng-if="category.id != isEditCat.id" ng-click="editCat(category)" class="btn btn-warning btn-sm">Edit</a>
                            <a href="" ng-click="removeCat(category)" class="btn btn-danger btn-sm">Remove</a>
                            <hr class="w-50 customhr">
                            <!--Category Name -->

                            <!--   Add link appears only when hover -->
                            <a href="" ng-click="activateAddLink(category)" ng-show="!addLink">Add New Link</a>
                            <div class="card add my-3 bg-new" ng-if="showAddLink.name == category.name">
                                <a href="" ng-click="cancelAdd()"><i class="fas fa-times text-muted float-left removeicon"></i></a>
                                <div class="addlink">

                                    <form ng-submit="saveLink(category)">
                                        <textarea class="form-control form-control-sm addfields" placeholder="Paste your link" ng-model="link.url" ng-keyup="search"></textarea>
                                        <input type="text" class="form-control form-control-sm  addfields" ng-model="link.tags" style="border-right: 0px; border-bottom: 0px; border-left: 0px; border-top:1px solid #756a4e;" placeholder="Write anything to remember this link." name="">
                                        <input type="submit" value="Save" class="btn btn-primary btn-sm" style="display:none"/>
                                    </form>
                                </div>
                                <small>Hit enter!</small>
                            </div>

                            <!--  link card -->
                            <div class="card cardlink my-3" ng-repeat="l in links | filter:search" ng-if="l.cat_id == category.id">
                                <div class="card-body">
                                    <p ng-click="executeUrl(l.url)"><%l.url%></p>
                                    <small class="text-muted"><%l.tags%></small>
                                    <a href="" ng-click="removeLink(l)"><i class="fas fa-times text-muted float-left removeicon"></i></a>
                                    <i class="fas fa-external-link-alt text-muted float-right" ng-click="executeUrl(l.url)"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- <div align="center">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th ng-repeat="category in categories">
                        <span ng-if="category.id != isEditCat.id"><%category.name%></span>
                        <form ng-if="category.id == isEditCat.id" ng-submit="saveCatChanges()">
                            <input type="text" ng-model="isEditCat.name"/>
                            <input type="submit" value="Save Changes" style="display:none">
                        </form>
                        <a href="" ng-if="category.id != isEditCat.id" ng-click="editCat(category)" class="btn btn-warning btn-sm">Edit</a>
                        <a href="" ng-click="removeCat(category)" class="btn btn-danger btn-sm">Remove</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                   <td ng-repeat="category in categories">
                       <a href="" ng-click="activateAddLink(category)" ng-show="!addLink">Add New Link</a>
                       <div class="card" ng-if="showAddLink.name == category.name">
                            <div class="card-header">Add New Link</div>
                            <div class="card-body">
                                <form ng-submit="saveLink(category)">
                                    <input type="text" ng-model="link.url" ng-keyup="search" placeholder="type Link here and press enter" class="form-control"/>
                                    <br/>
                                    <input type="text" ng-model="link.tags" placeholder="Enter tags coma saperated" class="form-control">
                                    <a href="" ng-click="cancelAdd()" class="btn btn-danger btn-sm" style="margin-top:3px">Cancel</a>
                                    <input type="submit" value="Save" class="btn btn-primary btn-sm" style="display:none"/>
                                </form>
                            </div>
                        </div>
                        <div class="card" style="margin-bottom:10px;" ng-repeat="l in links | filter:search" ng-if="l.cat_id == category.id">
                            <div class="card-header" ng-if="isEditLink.id != l.id"><span style="cursor:pointer" ng-click="executeUrl(l.url)"><%l.url%></span>&nbsp;&nbsp;<a href="" ng-click="activateEditLink(l)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a href="" ng-click="removeLink(l)" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></div>
                            <div class="card-header" ng-if="isEditLink.id == l.id">
                                 <form ng-submit="updatedLink(isEditLink)">
                                    <input type="text" ng-model="isEditLink.url" ng-keyup="search" placeholder="type Link here and press enter" class="form-control"/>
                                    <br/>
                                    <input type="text" ng-model="isEditLink.tags" placeholder="Enter tags coma saperated" class="form-control">
                                    <a href="" ng-click="cancelEditLink()" class="btn btn-danger btn-sm" style="margin-top:3px">Cancel</a>
                                    <input type="submit" value="Save" class="btn btn-primary btn-sm" style="display:none"/>
                                </form>
                            </div>
                        </div>
                   </td>
                </tr>
            </tbody>
        </table>
    </div> -->

    <!--footer-->
    <footer class="py-6">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 mr-auto">
                    <h6>SaveLinks</h6>
                    <p class="text-muted">We built this tool in just 24 hours to save our links in a better place so that we can find out when they are needed later.</p>
                </div>

                <div class="col-sm-2">
                    <h6>We built it</h6>
                    <img src="https://www.pinclipart.com/picdir/big/6-64226_dashed-clip-art-clipground-dotted-swirl-line-png.png" class="w-100">
                    <!-- <ul class="list-unstyled">
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Log in</a></li>
                    </ul> -->
                </div>

                <div class="col-sm-3 text-center">
                    <img src="https://avatars.io/twitter/im_usamakhalid" alt="Usama Khalid" class="rounded-circle w-50">
                    <h6 class="mt-2">Usama Khalid</h6>
                    <small>Hey 🖐<br>I'm a product maker, running multiple SaaS products. I make. I design but more into growing digital products.<br> Let's connect! </small>
                    <ul class="list-unstyled">
                        <li>
                            <a href="https://linkedin.com/in/imusamakhalid"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="https://instagram.com/im.usamakhalid"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-3 text-center">
                    <img src="https://avatars.io/twitter/affanak43" alt="Affan Khan" class="rounded-circle w-50">
                    <h6 class="mt-2">Affan Khan</h6>
                    <small>Hey 🖐<br>I am a Full Stack Engineer, Blockchain Developer, and Growth Enthusiast.<br> Developed multiple digital products.<br> Let's connect! 
                    </small>
                    <ul class="list-unstyled">
                        <li>
                            <a href="https://www.linkedin.com/in/affanak/"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/affan.ak43/"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-muted text-center small-xl">
                    &copy; 2020 SaveLinks - All Rights Reserved
                </div>
            </div>
        </div>
    </footer>

    <!--scroll to top-->
    <div class="scroll-top">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>

    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script>

        let myModule = angular.module("myModule",[],function($interpolateProvider)
        {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });

        myModule.controller("myController",function($scope,$http){
            $scope.addCat = false;
            $scope.addLink = false;
            $scope.availableToEdit = {};
            $scope.linkAvailableToEdit = {};
            $scope.categories = [];
            $scope.showAddLink = {};
            $scope.links = [];
            $scope.link = {};
            $scope.isEditCat = {};
            $scope.isEditLink = {};
            $scope.token = null;
            $scope.email = "";
            $scope.isEmailShow = true;
            $scope.isLoaderShow = false;

            $scope.verifyEmail = function(){
                $scope.isLoaderShow = true;
                $scope.isEmailShow = false;
                $http({
                    url:"{{URL::to('api/verifyEmail')}}",
                    method:"POST",
                    data:{tokenId:$scope.token.id,email:$scope.email}
                }).then(response => {
                    if(response.data.response == "Email send successfully and data saved"){
                        $scope.message = response.data.response;
                        $scope.token.email = $scope.email;
                        $scope.isEmailShow = false;
                        $scope.isLoaderShow = false;
                    }else{
                        $scope.isLoaderShow = false;
                        $scope.isEmailShow = true;
                        $scope.message = "Email already existed old link sent to email data could not save in this email";
                    }
                })
            }


            $scope.checkStorage = function(){
               let token = localStorage.getItem("token");
               let serverToken = "{{(isset($info) ? $info->token : '')}}";
               let tokenId = "{{(isset($info) ? $info->id : '')}}";
               let tokenEmail = "{{(isset($info) ? $info->email : '')}}";
               if(serverToken != ''){
                token = {id:tokenId,token:serverToken,email:tokenEmail};        
                localStorage.setItem("token",JSON.stringify(token));           
               }



               if(token == null){
                   $http({
                       url:"{{URL::to('api/getFreshToken')}}",
                       method:"GET"
                   }).then(response => {
                      localStorage.setItem("token",JSON.stringify(response.data));
                      $scope.token = JSON.parse(localStorage.getItem("token"));
                      if($scope.token.email == ''){
                        $scope.isEmailShow = true;
                      }else{
                        console.log('show1')
                        $scope.isEmailShow = false;
                      }
                      $http({
                        url:"{{URL::to('/api/allCategories')}}/" + $scope.token.id,
                        method:"GET"
                        }).then(response => {
                        $scope.categories = response.data;
                        });
                   }) 
               }else{
                   $scope.token = JSON.parse(localStorage.getItem("token"));
                   if($scope.token.email == ''){
                        $scope.isEmailShow = true;
                      }else{
                        console.log('show2')
                        $scope.isEmailShow = false;
                      }
                   //getting data on run time
                    $http({
                        url:"{{URL::to('/api/allCategories')}}/" + $scope.token.id,
                        method:"GET"
                    }).then(response => {
                    $scope.categories = response.data;
                    });
                    //getting old links
                    $http({
                    url:"{{URL::to('api/fetcholdlinks')}}/"+$scope.token.id,
                    method:"GET"
                    }).then(response => {
                        $scope.links = response.data;
                        console.log($scope.links);
                    });
               }

               console.log($scope.token);

            }

            

            


            $scope.cancelAdd = function(){
                $scope.addLink = false;
                $scope.showAddLink = {};
            }

            $scope.cancelEditLink = function(){
                $scope.isEditLink = {};
            }

            $scope.activateEditLink = function(link){
                $scope.isEditLink = {...link};
                $scope.availableToEdit = link;
            }

            $scope.showCat = function(){
                $scope.addCat = !$scope.addCat;
            }

            $scope.editCat = function(category){
                $scope.availableToEdit = category;
                $scope.isEditCat = {...category};
            }

            $scope.updatedLink = function(link){
               let linkToEdit = {...$scope.isEditLink,"tokenId":$scope.token.id};
               
               $scope.isEditLink = {};
               $http({
                   url:"{{URL::to('/api/updateLink')}}",
                   method:"POST",
                   data:linkToEdit
               }).then(response => {
                    if(response.data.response != "Error"){
                        for(i = 0;i<$scope.links.length;i++){
                            if($scope.links[i].id == linkToEdit.id){
                                $scope.links[i] = linkToEdit;
                            }
                        }
                    }
               });
            }

            $scope.saveCatChanges = function(){
                let categoryToEdit = {...$scope.isEditCat,tokenId:$scope.token.id};
                $scope.isEditCat = {};
                $http({
                    url:"{{URL::to('/api/editCat')}}",
                    method:"POST",
                    data:categoryToEdit
                }).then(response => {
                    if(response.data.response != 'Error'){
                    
                        for(i = 0;i<$scope.categories.length;i++){
                            if($scope.categories[i].id == categoryToEdit.id){
                                $scope.categories[i] = categoryToEdit;
                            }
                        }
                       
                    }
                })

            }

            $scope.removeCat = category => {
                let answer = confirm("Are you sure you want to remove " + category.name);
                if(answer == true){
                    $scope.categories = $scope.categories.filter(cat => cat.name != category.name);
                    $http({
                        url:"{{URL::to('api/removeCategory')}}/" + category.name,
                        method:"GET"
                    }).then(response => {
                        console.log(response.data);
                    })
                }
            }

            $scope.activateAddLink = function(category){
                $scope.addLink = true;
                $scope.showAddLink = category;
            }

            $scope.executeUrl = function(url){
               window.open(url);
            }

            $scope.removeLink = function(link){
                let answer = confirm("Are you sure you want to remove " + link.url);
                if(answer == true){
                    $scope.links = $scope.links.filter(x => x.id != link.id);
                    $http({
                        url:"{{URL::to('/api/removeLink/')}}/" + link.id,
                        method:"GET"
                    }).then(response => {
                        console.log(response.data);
                    })
                }
            }


            $scope.saveLink = function(category){
               let catId = category.id;
               if (!$scope.link.url.startsWith("http://") && !$scope.link.url.startsWith("https://")){
                $scope.link.url = "http://"+$scope.link.url
               }
               $http({
                   method:"POST",
                   url:"{{URL::to('/api/saveLink')}}",
                   data:{cat_id:catId,url:$scope.link.url,tags:$scope.link.tags,tokenId:$scope.token.id}
               }).then(response => {
                    if(response.data.response != "Error"){

                        let insertId = response.data.response;
                        let link = {
                            id:insertId,
                            url:$scope.link.url.slice(),
                            tags:$scope.link.tags.slice(),
                            cat_id:catId,
                            tokenId:$scope.token.id
                        };
                        $scope.links.push(link);
                    }
                   $scope.link = {};
                   $scope.cancelAdd();
               })
            }

            $scope.saveCategory = function(){

                if($scope.catName.length >= 3){


                    $scope.addCat = false;
                    $http({
                        url:"{{URL::to('/api/saveCategory')}}",
                        method:"POST",
                        data:{"newName":$scope.catName,"tokenId":$scope.token.id}
                    }).then(response => {
                        $scope.categories.push({id:response.data.response,name:$scope.catName.slice(),created_at:"",upated_at:""});
                         $scope.catName = "";

                    });

                }else{
                    alert("Please enter at least more then 3 charecters in category new name");
                }

            }
        });

    </script>
</body>
</html>
