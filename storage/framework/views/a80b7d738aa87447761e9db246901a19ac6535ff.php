<?php if($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType'])): ?>
<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center <?php echo e($configData['navbarColor']); ?>" data-nav="brand-center">
  <div class="navbar-header d-xl-block d-none">
    <ul class="nav navbar-nav">
      <li class="nav-item">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
          <span class="brand-logo">
            <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
              <defs>
                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                  <stop stop-color="#000000" offset="0%"></stop>
                  <stop stop-color="#FFFFFF" offset="100%"></stop>
                </lineargradient>
                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                  <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                  <stop stop-color="#FFFFFF" offset="100%"></stop>
                </lineargradient>
              </defs>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                  <g id="Group" transform="translate(400.000000, 178.000000)">
                    <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                    <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                    <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                    <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                    <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                  </g>
                </g>
              </g>
            </svg>
          </span>
          <h2 class="brand-text mb-0">Vuexy</h2>
        </a>
      </li>
    </ul>
  </div>
  <?php else: ?>
  <nav class="header-navbar navbar navbar-expand-lg align-items-center <?php echo e($configData['navbarClass']); ?> navbar-light navbar-shadow <?php echo e($configData['navbarColor']); ?> <?php echo e($configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : ''); ?>">
    <?php endif; ?>
    <div class="navbar-container d-flex content">
      <div class="bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav d-xl-none">
          <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><em class="ficon" data-feather="menu"></em></a></li>
        </ul>
        <ul class="nav navbar-nav">
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link nav-link-style">
              <em class="ficon" data-feather="<?php echo e($configData['theme'] === 'dark' ? 'sun' : 'moon'); ?>"></em>
            </a>
          </li>
          <!-- <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon" data-feather="search"></i></a>
            <div class="search-input">
              <div class="search-input-icon"><i data-feather="search"></i></div>
              <input class="form-control input" type="text" placeholder="الوصول السريع لخدمات نظام ابنائي .." tabindex="-1" data-search="search">
              <div class="search-input-close"><i data-feather="x"></i></div>
              <ul class="search-list search-list-main"></ul>
            </div>
          </li> -->
        </ul>

        <label class="mx-1">المجمع الدراسي :</label>
        <ul class="nav navbar-nav ms-auto">

          <li class="nav-item d-none d-lg-block">
            <div class="nav-link">
              <?php echo Form::open(['route' => 'corporates.switch','method'=>'POST' , 'onsubmit' => 'showLoader()','name' => 'corporate_switch_form']); ?>


              <select class="form-select" name="corprate_id" onchange="changeCorporate()">
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                  <?php $__currentLoopData = corporates(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corporate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option <?php if(session()->has('seleted_corprate') && session('seleted_corprate')->id == $corporate->id): ?> selected <?php endif; ?> value="<?php echo e($corporate->id); ?>"><?php echo e($corporate->corporate_name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </select>
              <?php echo Form::close(); ?>


            </div>
          </li>
        </ul>
      </div>


      <ul class="nav navbar-nav align-items-center ms-auto">
        <?php if(Route::has('notifications.index')): ?>
        <?php $notfication = GetUserNotification() ?>
        <li class="nav-item dropdown dropdown-notification me-50">
          <a class="nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
            <em class="ficon" data-feather="bell"></em>
            <?php if(count($notfication)): ?>
            <span class="badge rounded-pill bg-danger badge-up"><?php echo e(count($notfication)); ?></span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
            <li class="dropdown-menu-header">
              <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">الأشعارات</h4>
                <?php if(count($notfication)): ?>
                <div class="badge rounded-pill badge-light-primary"><?php echo e(count($notfication)); ?> اشعار جديد</div>
                <?php endif; ?>
              </div>
            </li>
            <li class="scrollable-container media-list">
              <?php $__currentLoopData = $notfication; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a class="d-flex" href="<?php echo e($item->internal_url ?  $item->internal_url : 'javascript:void(0)'); ?>">
                <div class="list-item d-flex align-items-start">
                  <div class="me-1">
                    <?php if($item->sent): ?>
                    <div class="avatar bg-light-success">
                      <div class="avatar-content"><em class="avatar-icon" data-feather="check"></em></div>
                    </div>
                    <?php else: ?>
                    <div class="avatar bg-light-danger">
                      <div class="avatar-content"><em class="avatar-icon" data-feather="x"></em></div>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="list-item-body position-relative flex-grow-1">
                    <p class="media-heading d-flex"> <span class="fw-bolder"><?php echo e($item->notification_name); ?></span>
                      <small class="position-absolute top-0 end-0"><?php echo e($item->created_at->diffforhumans()); ?></small>
                    </p>
                    <small class="notification-text"> <?php echo e($item->notification_text); ?></small>
                  </div>
                </div>
              </a>

              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </li>
            <li class="dropdown-menu-footer">
              <a class="btn btn-primary w-100" href="<?php echo e(route('MyNotifications')); ?>">جميع الأشعارات</a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <li class="nav-item dropdown dropdown-user">
          <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-bs-toggle="dropdown" aria-haspopup="true">
            <div class="user-nav d-sm-flex d-none">
              <span class="user-name fw-bolder">
                <?php if(Auth::check()): ?>
                <?php echo e(Auth::user()->first_name); ?>

                <?php else: ?>
                John Doe
                <?php endif; ?>
              </span>
              <span class="user-status">
                <?php echo e(Auth::user()->admin->job_title ?? 'الأدارة'); ?>

              </span>
            </div>
            <span class="avatar">
              <img class="round" src="<?php echo e(Auth::user() && Storage::exists('Auth::user()->profile_photo_url') ? Auth::user()->profile_photo_url : asset('images/portrait/small/avatar-s-11.jpg')); ?>" alt="avatar" height="40" width="40">
              <span class="avatar-status-online"></span>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
            <h6 class="dropdown-header">ادارة الحساب</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo e(Route::has('profile.show') ? route('profile.show') : 'javascript:void(0)'); ?>">
              <em class="me-50" data-feather="user"></em> حسابي
            </a>
            <?php if(Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures()): ?>
            <a class="dropdown-item" href="<?php echo e(route('api-tokens.index')); ?>">
              <em class="me-50" data-feather="key"></em> API Tokens
            </a>
            <?php endif; ?>

            <?php if(Auth::User() && Laravel\Jetstream\Jetstream::hasTeamFeatures()): ?>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Manage Team</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo e(Auth::user() ? route('teams.show', Auth::user()->currentTeam->id) : 'javascript:void(0)'); ?>">
              <em class="me-50" data-feather="settings"></em> Team Settings
            </a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', Laravel\Jetstream\Jetstream::newTeamModel())): ?>
            <a class="dropdown-item" href="<?php echo e(route('teams.create')); ?>">
              <em class="me-50" data-feather="users"></em> Create New Team
            </a>
            <?php endif; ?>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">
              Switch Teams
            </h6>
            <div class="dropdown-divider"></div>
            <?php if(Auth::user()): ?>
            <?php $__currentLoopData = Auth::user()->allTeams(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.switchable-team','data' => ['team' => $team]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-switchable-team'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($team)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <div class="dropdown-divider"></div>
            <?php endif; ?>
            <?php if(Auth::check()): ?>
            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <em class="me-50" data-feather="power"></em> تسجيل الخروج
            </a>
            <form method="POST" id="logout-form" action="<?php echo e(route('logout')); ?>">
              <?php echo csrf_field(); ?>
            </form>
            <?php else: ?>
            <a class="dropdown-item" href="<?php echo e(Route::has('login') ? route('login') : 'javascript:void(0)'); ?>">
              <em class="me-50" data-feather="log-in"></em> تسجيل الدخول
            </a>
            <?php endif; ?>
          </div>
        </li>
      </ul>

    </div>
  </nav>

  
  <ul class="main-search-list-defaultlist d-none">
    <li class="d-flex align-items-center">
      <a href="javascript:void(0);">
        <h6 class="section-label mt-75 mb-0">Files</h6>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between w-100" href="<?php echo e(url('app/file-manager')); ?>">
        <div class="d-flex">
          <div class="me-75">
            <img src="<?php echo e(asset('images/emcons/xls.png')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">Two new item submitted</p>
            <small class="text-muted">Marketing Manager</small>
          </div>
        </div>
        <small class="search-data-size me-50 text-muted">&apos;17kb</small>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between w-100" href="<?php echo e(url('app/file-manager')); ?>">
        <div class="d-flex">
          <div class="me-75">
            <img src="<?php echo e(asset('images/emcons/jpg.png')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">52 JPG file Generated</p>
            <small class="text-muted">FontEnd Developer</small>
          </div>
        </div>
        <small class="search-data-size me-50 text-muted">&apos;11kb</small>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between w-100" href="<?php echo e(url('app/file-manager')); ?>">
        <div class="d-flex">
          <div class="me-75">
            <img src="<?php echo e(asset('images/emcons/pdf.png')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">25 PDF File Uploaded</p>
            <small class="text-muted">Digital Marketing Manager</small>
          </div>
        </div>
        <small class="search-data-size me-50 text-muted">&apos;150kb</small>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between w-100" href="<?php echo e(url('app/file-manager')); ?>">
        <div class="d-flex">
          <div class="me-75">
            <img src="<?php echo e(asset('images/emcons/doc.png')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">Anna_Strong.doc</p>
            <small class="text-muted">Web Designer</small>
          </div>
        </div>
        <small class="search-data-size me-50 text-muted">&apos;256kb</small>
      </a>
    </li>
    <li class="d-flex align-items-center">
      <a href="javascript:void(0);">
        <h6 class="section-label mt-75 mb-0">Members</h6>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between py-50 w-100" href="<?php echo e(url('app/user/view')); ?>">
        <div class="d-flex align-items-center">
          <div class="avatar me-75">
            <img src="<?php echo e(asset('images/portrait/small/avatar-s-8.jpg')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">John Doe</p>
            <small class="text-muted">UI designer</small>
          </div>
        </div>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between py-50 w-100" href="<?php echo e(url('app/user/view')); ?>">
        <div class="d-flex align-items-center">
          <div class="avatar me-75">
            <img src="<?php echo e(asset('images/portrait/small/avatar-s-1.jpg')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">Michal Clark</p>
            <small class="text-muted">FontEnd Developer</small>
          </div>
        </div>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between py-50 w-100" href="<?php echo e(url('app/user/view')); ?>">
        <div class="d-flex align-items-center">
          <div class="avatar me-75">
            <img src="<?php echo e(asset('images/portrait/small/avatar-s-14.jpg')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">Milena Gibson</p>
            <small class="text-muted">Digital Marketing Manager</small>
          </div>
        </div>
      </a>
    </li>
    <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between py-50 w-100" href="<?php echo e(url('app/user/view')); ?>">
        <div class="d-flex align-items-center">
          <div class="avatar me-75">
            <img src="<?php echo e(asset('images/portrait/small/avatar-s-6.jpg')); ?>" alt="png" height="32">
          </div>
          <div class="search-data">
            <p class="search-data-title mb-0">Anna Strong</p>
            <small class="text-muted">Web Designer</small>
          </div>
        </div>
      </a>
    </li>
  </ul>

  
  <ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion justify-content-between">
      <a class="d-flex align-items-center justify-content-between w-100 py-50">
        <div class="d-flex justify-content-start">
          <span class="me-75" data-feather="alert-circle"></span>
          <span>No results found.</span>
        </div>
      </a>
    </li>
  </ul>
  
  <!-- END: Header--><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/panels/navbar.blade.php ENDPATH**/ ?>