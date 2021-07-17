<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-user fa-2x"></i>
            </span> <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>
        </h3>
    </div>
    <div class="card">
        <div id="profile-result" class="text-center" tabindex="0"></div>
        <div class="card-body">
            <form class="form-sample">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">username</label>
                            <div class="col-sm-9">
                                <input type="text" id="username"
                                    value="<?php print_r($data['row']['0']['username']); ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">email</label>
                            <div class="col-sm-9">
                                <input type="email" id="email" value="<?php print_r($data['row']['0']['email']) ?>"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Admin</label>
                            <div class="col-sm-9">
                                <select class="form-control">
                                    <?php if(($data['row']['0']['is_admin']) === "true"): ?>
                                    <option>True</option>
                                    <?php else: ?>
                                    <option>False</option>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date Created</label>
                            <div class="col-sm-9">
                                <input class="form-control"
                                    value="<?php echo date('jS F Y',strtotime($data['row']['0']['date_created'])) ?> at <?php echo date('h:i:s A',strtotime($data['row']['0']['time_created'])) ?>"
                                    placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Notifications</label>
                            <div class="col-sm-9">
                                <select class="form-control">
                                    <option value="on">on</option>
                                    <option value="off">off</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Receive Updates</label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="membershipRadios"
                                            id="membershipRadios1" value="" checked=""> Yes <i
                                            class="input-helper"></i></label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="membershipRadios"
                                            id="membershipRadios2" value="option2"> No <i
                                            class="input-helper"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="card-description"> Password </p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Old password</label>
                            <div class="col-sm-9">
                                <input type="password" id="old" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" id="new" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="save-profile" class="btn btn-lg btn-gradient-info"
                    onclick="$('#profile-result')[0].focus()">Save</button>
                <div id="profile-loading">Loading&#8230;</div>
            </form>
        </div>
    </div>
</div>