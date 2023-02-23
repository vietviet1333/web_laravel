@extends('Client.Layout')
@section('body')
<main class="mainContent-theme">
    <section class="breadcrumb-theme   mb-0 "  >
        <div class="container-fluid">
            <div class="breadcrumb-list">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                          
                            <meta itemprop="position" content="1" />
                        </li>


                    </ol>
                </nav>
            </div>


        </div>
    </section>				<div class="layout-info-account">
        <div class="title-infor-account text-center">
            <h1>Your Account </h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3 sidebar-account">
                    <div class="AccountSidebar">
        <h3 class="AccountTitle titleSidebar">Account</h3>
        <div class="AccountContent">
            <div class="AccountList">
                <ul class="list-unstyled">

       
                    <li class="last"><a href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
                </div>
                <div class="col-12 col-sm-9" >
                    @foreach ($profilee as $c)


                    <div class="row">
                        <div class="col-12" id="customer_sidebar">
                            <p class="title-detail">Account information</p>
                            <div class="d-flex align-items-center justify-content-between">

                               <h2 class="name_account" >{{$c->name}}</h2>

                                <a id="update_profile" href="/editprofile/{{$c->id}}">Update information</a>
                            </div>
                            <h2 class="name_account" >{{$c->address}}</h2>
                           <p class="email ">{{$c->email}}</p>


                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
                </main>
@endsection
@section('script')
@endsection
