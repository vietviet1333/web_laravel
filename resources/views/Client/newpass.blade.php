@extends('Client.Layout')
@section('body')

<main class="mainContent-theme">
    <section class="breadcrumb-theme   mb-0 ">
        <div class="container-fluid">
            <div class="breadcrumb-list">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope
                            itemtype="http://schema.org/ListItem">
                          
                            <meta itemprop="position" content="1" />
                        </li>

                       

                    </ol>
                </nav>
            </div>


        </div>
    </section>
    <div class="layout-account"  >
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12 wrapbox-heading-account">
                    <div class="header-page clearfix">
                        <h1>NEW PASS</h1>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 wrapbox-content-account ">
                    <div class="userbox">
                        <div class="container">
                            <form action="/savepass/{{$phong}}" method="get">
                                <p class="fw-bold" style="text-align: center" >Hello: {{$phong}}</p>

                            <div class="form-floating">
                                <input type="password" class="form-control mt-5 mb-5 " id="floatingPassword" placeholder="Password" name="newpass"  >
                                <label for="floatingPassword"  >New Password</label>
                               <div class="container" style="text-align: center" > <button  class="editUser btn btn-danger" type="submit"
                                style="min-width:90px;padding: 5px 10px;">Save changes</button></div>
                              </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
