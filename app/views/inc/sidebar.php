            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="<?php echo URLROOT; ?>/users/profile" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="<?php echo URLROOT; ?>/public/images/images/avatar.png" alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span
                                    class="font-weight-bold mb-2"><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] . ' OG': 'N/A'; ?></span>
                                <span class="text-secondary text-small">admin</span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>">
                            <span class="menu-title">Home</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Stations</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-gate menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo URLROOT; ?>/pages/playstation">Ps</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo URLROOT; ?>/pages/movieShop">MovieShop</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo URLROOT; ?>/pages/cyber">Cyber</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo URLROOT; ?>/pages/sales">Sales</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo URLROOT; ?>/pages/expenses">Expenses</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo URLROOT; ?>/pages/total">Total</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo URLROOT; ?>/pages/dailyreport">dailyreport</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/pages/trends">
                            <span class="menu-title">Trends</span>
                            <i class="mdi mdi-chart-areaspline menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#inventory" aria-expanded="false"
                            aria-controls="inventory">
                            <span class="menu-title">Inventory</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-truck-delivery menu-icon"></i>
                        </a>
                        <div class="collapse" id="inventory">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="<?php echo URLROOT; ?>/pages/addItem">
                                        Create
                                        New</a></li>
                                <li class="nav-item"> <a class="nav-link" href="<?php echo URLROOT; ?>/pages/list"> list
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#receipts" aria-expanded="false"
                            aria-controls="receipts">
                            <span class="menu-title">Receipts</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-fax menu-icon"></i>
                        </a>
                        <div class="collapse" id="receipts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="<?php echo URLROOT; ?>/pages/invoices">
                                        Invoices</a></li>
                                <li class="nav-item"> <a class="nav-link" href="<?php echo URLROOT; ?>/pages/cashouts">
                                        cashouts </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/pages/cashout">
                            <span class="menu-title">Make cashout</span>
                            <i class="mdi mdi-cash-multiple menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item sidebar-actions">
                        <span class="nav-link">
                            <div class="border-bottom">
                                <h6 class="font-weight-normal mb-3">Sale</h6>
                            </div>
                            <a href="<?php echo URLROOT; ?>/pages/sale"
                                class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Add Sale</a>

                        </span>
                    </li>
                </ul>
            </nav>