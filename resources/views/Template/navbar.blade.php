<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-20">
                        <button id="menu-toggle" class="main-btn success-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                    <div class="header-search d-none d-md-flex">
                        {{-- <form action="#">
                <input type="text" placeholder="Search..." />
                <button><i class="lni lni-search-alt"></i></button>
              </form> --}}
                        <div class="header-right flex align-items-center">
                            <div class="filter-box ml-15 d-none d-md-flex me-2">
                                <button class="" id="filter">
                                    <i class="lni lni-code"></i>
                                </button>
                            </div>
                            <div class="info">
                                <h6> PORTAL TRAHS MONITORING SYSTEM</h6>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-6">
                <div class="header-right">
                    {{-- <!-- notification start -->
            <div class="notification-box ml-15 d-none d-md-flex">
              <button
                class="dropdown-toggle"
                type="button"
                id="notification"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="lni lni-alarm"></i>
                <span>2</span>
              </button>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="notification"
              >
                <li>
                  <a href="#0">
                    <div class="image">
                      <img src="{{asset('images/lead/lead-6.png')}}" alt="" />
                </div>
                <div class="content">
                    <h6>
                        John Doe
                        <span class="text-regular">
                            comment on a product.
                        </span>
                    </h6>
                    <p>
                        Lorem ipsum dolor sit amet, consect etur adipiscing
                        elit Vivamus tortor.
                    </p>
                    <span>10 mins ago</span>
                </div>
                </a>
                </li>
                <li>
                    <a href="#0">
                        <div class="image">
                            <img src="assets/images/lead/lead-1.png" alt="" />
                        </div>
                        <div class="content">
                            <h6>
                                Jonathon
                                <span class="text-regular">
                                    like on a product.
                                </span>
                            </h6>
                            <p>
                                Lorem ipsum dolor sit amet, consect etur adipiscing
                                elit Vivamus tortor.
                            </p>
                            <span>10 mins ago</span>
                        </div>
                    </a>
                </li>
                </ul>
            </div>
            <!-- notification end -->
            <!-- message start -->
            <div class="header-message-box ml-15 d-none d-md-flex">
                <button class="dropdown-toggle" type="button" id="message" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="lni lni-envelope"></i>
                    <span>3</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="message">
                    <li>
                        <a href="#0">
                            <div class="image">
                                <img src="assets/images/lead/lead-5.png" alt="" />
                            </div>
                            <div class="content">
                                <h6>Jacob Jones</h6>
                                <p>Hey!I can across your profile and ...</p>
                                <span>10 mins ago</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#0">
                            <div class="image">
                                <img src="assets/images/lead/lead-3.png" alt="" />
                            </div>
                            <div class="content">
                                <h6>John Doe</h6>
                                <p>Would you mind please checking out</p>
                                <span>12 mins ago</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#0">
                            <div class="image">
                                <img src="assets/images/lead/lead-2.png" alt="" />
                            </div>
                            <div class="content">
                                <h6>Anee Lee</h6>
                                <p>Hey! are you available for freelance?</p>
                                <span>1h ago</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- message end -->
            <!-- filter start --> --}}

            <!-- filter end -->
            <!-- profile start -->
            <div class="profile-box ml-15">
                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                        <div class="info">
                            <h6>Username</h6>
                            <div class="image">
                                <img src="{{asset('images/profile/profile-image.png')}}" alt="" />
                                <span class="status"></span>
                            </div>
                        </div>
                    </div>
                    <i class="lni lni-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                    <li>
                        <a class="dropdown-item" href="" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="lni lni-exit"></i> Sign Out
                        </a>
                        <form id="" action="" method="POST" class="d-none">
                            <!-- @csrf -->
                        </form>
                    </li>
                </ul>
            </div>
            <!-- profile end -->
        </div>
    </div>
    </div>
    </div>
</header>